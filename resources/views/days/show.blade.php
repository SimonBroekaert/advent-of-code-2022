<x-layout>
    <div>
        <h1>
            <a href="{{ route('days.index') }}">
                Return to overview
            </a>
        </h1>
    </div>
    @if ($question1)
        <div>
            <h1>Question 1: {{ $question1 }}</h1>
            <p>Answer: {{ $answer1 ?? 'Not answered yet' }}</p>
        </div>
    @endif
    @if ($question2)
        <div>
            <h1>Question 2: {{ $question2 }}</h1>
            <p>Answer: {{ $answer2 ?? 'Not answered yet' }}</p>
        </div>
    @endif
</x-layout>
