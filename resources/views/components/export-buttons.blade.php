@props(["list", "extraParams" => ""])
<div class="d-flex gap-2">
    <a href="{{ route("admin.export.excel", $list) }}{{ $extraParams }}" class="btn btn-sm btn-success fw-bold d-flex align-items-center gap-1" title="Exportar Excel">
        <i class="fa-solid fa-file-excel"></i>
        <span class="d-none d-md-inline">Excel</span>
    </a>
    <a href="{{ route("admin.export.pdf", $list) }}{{ $extraParams }}" class="btn btn-sm btn-danger fw-bold d-flex align-items-center gap-1" title="Exportar PDF" target="_blank">
        <i class="fa-solid fa-file-pdf"></i>
        <span class="d-none d-md-inline">PDF</span>
    </a>
</div>
