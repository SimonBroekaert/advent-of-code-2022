<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;

class DaySevenController extends Controller
{
    public function __invoke(): View
    {
        $structure = $this->getDirStructure();

        $question1 = 'Sum of all directory sizes of directories smaller than 100000';
        $answer1 = $this->getSizeOfDirectoriesSmallerThan($structure, 100000);

        $question2 = null;
        $answer2 = null;

        return view('days.show', compact(
            'question1',
            'answer1',
            'question2',
            'answer2'
        ));
    }

    private function getDirStructure(): Collection
    {
        $commands = $this->getCommands();

        $structure = [];
        $currentDir = '';

        foreach ($commands as $command) {
            if ($command->type === 'cd') {
                $dir = $command->arguments[0];
                $currentDir = match ($dir) {
                    '..' => Str::beforeLast($currentDir, '.'),
                    '/' => '',
                    default => $currentDir === '' ? $dir : $currentDir . '.' . $dir,
                };
            }
            if ($command->type === 'ls') {
                $files = collect($command->output)->where('type', 'file')->toArray();
                data_set($structure, $currentDir === '' ? '_files' : $currentDir . '._files', $files);
            }
        }

        $structure = $this->calculateDirSizesRecursive(collect($structure));

        return collect($structure);
    }

    private function calculateDirSizesRecursive(Collection $structure): Collection
    {
        return $structure->map(function ($content, $dir) {
            $size = 0;

            $calculatedContent = [];
            if ($dir === '_files') {
                $size += collect($content)->sum('size');
            } else {
                $calculatedContent = $this->calculateDirSizesRecursive(collect($content));
            }

            $size += collect($calculatedContent)->sum('_size');

            return collect([
                ...$calculatedContent,
                '_size' => $size,
            ]);
        });
    }

    private function getCommands(): Collection
    {
        $file = Storage::disk('public')->get('day-7.txt');

        return collect(explode('$', $file))
            ->filter(fn ($line) => trim($line) !== '')
            ->map(function ($content) {
                $command = trim(Str::before($content, "\n"));
                $output = array_filter(explode("\n", trim(Str::after($content, "\n"))));

                return (object) [
                    'type' => Str::before($command, ' '),
                    'arguments' => Str::contains($command, ' ') ? array_map('trim', explode(' ', Str::after($command, ' '))) : null,
                    'output' => collect($output)->map(function ($outputLine) {
                        return (object) [
                            'type' => Str::before($outputLine, ' ') === 'dir' ? 'directory' : 'file',
                            'name' => Str::after($outputLine, ' '),
                            'size' => Str::before($outputLine, ' ') === 'dir' ? 0 : (int) Str::before($outputLine, ' '),
                        ];
                    })->toArray(),
                ];
            });
    }

    private function getSizeOfDirectoriesSmallerThan(Collection $structure, int $size): int
    {
        return $structure->filter(fn ($content, $dir) => $dir !== '_files')->sum(function ($content) use ($size) {
            $dirSize = $content['_size'] ?? 0;

            if ($dirSize < $size) {
                return $dirSize;
            }

            return $this->getSizeOfDirectoriesSmallerThan(collect($content), $size);
        });
    }
}
