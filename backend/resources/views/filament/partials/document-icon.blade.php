{{-- filepath: resources/views/filament/partials/document-icon.blade.php --}}
@php
    $ext = $extension ?? '';
@endphp
@if(in_array($ext, ['pdf']))
    <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconClasses }} text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 24 24" role="img" aria-label="PDF file icon">
        <rect width="24" height="24" rx="2" ry="2" fill="currentColor" />
        <text x="12" y="16" :fill="document.documentElement.classList.contains('dark') ? '#22223b' : 'white'" fill="white" font-size="10" font-weight="bold" text-anchor="middle" font-family="Arial, sans-serif">PDF</text>
    </svg>
@elseif(in_array($ext, ['doc', 'docx']))
    <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconClasses }} text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 24 24" role="img" aria-label="DOC file icon">
        <rect width="24" height="24" rx="2" ry="2" fill="currentColor" />
        <text x="12" y="16" :fill="document.documentElement.classList.contains('dark') ? '#22223b' : 'white'" fill="white" font-size="10" font-weight="bold" text-anchor="middle" font-family="Arial, sans-serif">DOC</text>
    </svg>
@elseif(in_array($ext, ['xls', 'xlsx']))
    <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconClasses }} text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 24 24" role="img" aria-label="XLS file icon">
        <rect width="24" height="24" rx="2" ry="2" fill="currentColor" />
        <text x="12" y="16" :fill="document.documentElement.classList.contains('dark') ? '#22223b' : 'white'" fill="white" font-size="10" font-weight="bold" text-anchor="middle" font-family="Arial, sans-serif">XLS</text>
    </svg>
@elseif(in_array($ext, ['ppt', 'pptx']))
    <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconClasses }} text-orange-600 dark:text-orange-400" fill="currentColor" viewBox="0 0 24 24" role="img" aria-label="PPT file icon">
        <rect width="24" height="24" rx="2" ry="2" fill="currentColor" />
        <text x="12" y="16" :fill="document.documentElement.classList.contains('dark') ? '#22223b' : 'white'" fill="white" font-size="10" font-weight="bold" text-anchor="middle" font-family="Arial, sans-serif">PPT</text>
    </svg>
@elseif(in_array($ext, ['jpg', 'jpeg', 'png', 'gif']))
    <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconClasses }} text-purple-600 dark:text-purple-400" fill="currentColor" viewBox="0 0 24 24" role="img" aria-label="Image file icon">
        <rect width="24" height="24" rx="2" ry="2" fill="currentColor" />
        <circle cx="12" cy="12" r="5" fill="#fff"/>
    </svg>
@else
    <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconClasses }} text-gray-500 dark:text-gray-300" fill="currentColor" viewBox="0 0 24 24" role="img" aria-label="Generic file icon">
        <rect width="24" height="24" rx="2" ry="2" fill="currentColor" />
    </svg>
@endif