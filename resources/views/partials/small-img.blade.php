@php
    $title = $this->mountedTableActionData['title'] ?? '';
@endphp
<div>
    <strong>{{ $title }}</strong>
    <img
        src="https://avatars.githubusercontent.com/u/17986190?s=120&v=4"
        alt="GH Avatar"
        title="{{ $title }}"
        style="max-height: 3rem;"
    >
</div>
