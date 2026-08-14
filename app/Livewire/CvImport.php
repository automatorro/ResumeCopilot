<?php

namespace App\Livewire;

use App\Models\CvImport as CvImportModel;
use App\Models\Certification;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Language;
use App\Models\Skill;
use App\Services\CvTextExtractor;
use App\Services\GeminiParser;
use Livewire\Component;
use Livewire\WithFileUploads;

class CvImport extends Component
{
    use WithFileUploads;

    public $file = null;
    public string $status = 'idle'; // idle | uploading | parsing | review | applied | error
    public string $errorMessage = '';
    public array $parsed = [];
    public string $applyMode = 'append'; // append | replace
    public ?int $importId = null;

    public function updatedFile(): void
    {
        $this->validate([
            'file' => 'required|file|mimes:pdf,docx,txt|max:10240',
        ]);
    }

    public function upload(): void
    {
        $this->validate([
            'file' => 'required|file|mimes:pdf,docx,txt|max:10240',
        ]);

        $this->status = 'uploading';

        $userId   = auth()->id();
        $original = $this->file->getClientOriginalName();
        $mime     = $this->file->getMimeType();
        $path     = $this->file->store("cv-imports/{$userId}", 'local');
        $fullPath = storage_path("app/{$path}");
        $hash     = hash_file('sha256', $fullPath);

        $import = CvImportModel::create([
            'user_id'      => $userId,
            'file_name'    => $original,
            'file_path'    => $path,
            'mime_type'    => $mime,
            'content_hash' => $hash,
            'status'       => 'parsing',
        ]);

        $this->importId = $import->id;
        $this->status   = 'parsing';

        try {
            $text   = app(CvTextExtractor::class)->extract($fullPath, $mime);
            $parsed = app(GeminiParser::class)->parseCV($text);

            $import->update(['status' => 'parsed', 'parsed_data' => $parsed]);
            $this->parsed = $parsed;
            $this->status = 'review';
        } catch (\Throwable $e) {
            $import->update(['status' => 'failed', 'error_message' => $e->getMessage()]);
            $this->errorMessage = $e->getMessage();
            $this->status       = 'error';
        }
    }

    public function apply(): void
    {
        $user   = auth()->user();
        $parsed = $this->parsed;
        $replace = $this->applyMode === 'replace';

        // Personal
        if (!empty($parsed['personal'])) {
            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                array_filter($parsed['personal'], fn ($v) => $v !== '' && $v !== null)
            );
        }

        // Career Brain
        $brainData = array_filter([
            'summary'     => $parsed['summary']     ?? null,
            'goals'       => $parsed['goals']       ?? null,
            'target_role' => $parsed['target_role'] ?? null,
        ], fn ($v) => $v !== '' && $v !== null);

        if ($brainData) {
            $user->careerBrain()->updateOrCreate(['user_id' => $user->id], $brainData);
        }

        // Experiences
        if (!empty($parsed['experiences'])) {
            if ($replace) $user->experiences()->delete();
            $max = $user->experiences()->max('sort_order') ?? 0;
            foreach ($parsed['experiences'] as $i => $exp) {
                Experience::create(array_merge($exp, [
                    'user_id'    => $user->id,
                    'sort_order' => $max + $i + 1,
                ]));
            }
        }

        // Educations
        if (!empty($parsed['educations'])) {
            if ($replace) $user->educations()->delete();
            $max = $user->educations()->max('sort_order') ?? 0;
            foreach ($parsed['educations'] as $i => $edu) {
                Education::create(array_merge($edu, [
                    'user_id'    => $user->id,
                    'sort_order' => $max + $i + 1,
                ]));
            }
        }

        // Skills
        if (!empty($parsed['skills'])) {
            if ($replace) $user->skills()->delete();
            $max = $user->skills()->max('sort_order') ?? 0;
            foreach ($parsed['skills'] as $i => $skill) {
                Skill::create(array_merge($skill, [
                    'user_id'    => $user->id,
                    'sort_order' => $max + $i + 1,
                ]));
            }
        }

        // Languages
        if (!empty($parsed['languages'])) {
            if ($replace) $user->languages()->delete();
            $max = $user->languages()->max('sort_order') ?? 0;
            foreach ($parsed['languages'] as $i => $lang) {
                Language::create(array_merge($lang, [
                    'user_id'    => $user->id,
                    'sort_order' => $max + $i + 1,
                ]));
            }
        }

        // Certifications
        if (!empty($parsed['certifications'])) {
            if ($replace) $user->certifications()->delete();
            $max = $user->certifications()->max('sort_order') ?? 0;
            foreach ($parsed['certifications'] as $i => $cert) {
                Certification::create(array_merge($cert, [
                    'user_id'    => $user->id,
                    'sort_order' => $max + $i + 1,
                ]));
            }
        }

        CvImportModel::find($this->importId)?->update(['status' => 'applied']);
        $this->status = 'applied';
    }

    public function reset(): void
    {
        $this->file         = null;
        $this->status       = 'idle';
        $this->errorMessage = '';
        $this->parsed       = [];
        $this->importId     = null;
    }

    public function render()
    {
        return view('livewire.cv-import');
    }
}
