@extends('admin.layouts')

@section('title', 'Content Versioning - CMS Admin')

{{-- 1. CSS SECTION --}}
@push('styles')
<style>

    .text-primary {
      color: #0076D2 !important;
    }
    /* Table Layout */
    #posts-table { 
        border-collapse: separate; 
        border-spacing: 0 12px; 
    }
    
    /* Header Styling - Menggunakan warna biru brand sesuai gambar */
    #posts-table thead th {
        background-color: #F1F9FA;
        color: #0076D2 !important;
        font-weight: 500;
        padding: 15px 12px;
        border: none;
        cursor: default !important;
    }
    /* Sembunyikan icon sortir bawaan */
    table.dataTable thead th::before, 
    table.dataTable thead th::after { display: none !important; }

    /* Body Row Styling - Efek Melayang */
    #posts-table tbody tr {
        background-color: #ffffff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        transition: all 0.2s ease;
    }
    #posts-table tbody td { 
        padding: 16px 12px; 
        border: none; 
        color: #444; 
    }
    
    /* Kelengkungan sudut baris */
    #posts-table tbody tr td:first-child { border-radius: 12px 0 0 12px; }
    #posts-table tbody tr td:last-child { border-radius: 0 12px 12px 0; }

    /* Badge Status & Action Buttons */
    .badge-status { 
        padding: 6px 16px; 
        border-radius: 50px; 
        font-weight: 600; 
    }
    .status-published { background-color: #e6f7ef; color: #1cc88a; }
    .status-draft { background-color: #fff4e6; color: #ff9f43; }

    .btn-restore {
        background-color: #e3f2fd; 
        color: #2196f3; 
        border: none; 
        border-radius: 10px;
        width: 38px; 
        height: 38px; 
        display: inline-flex; 
        align-items: center; 
        justify-content: center;
    }
    .btn-restore:hover { background-color: #2196f3; color: white; }
    
    .btn-expand { 
        background-color: transparent; 
        color: #2196f3; 
        border: none; 
        font-size: 1.2rem; 
        margin-left: 8px; 
    }

    /* Reset Bootstrap Defaults */
    .table > :not(caption) > * > * { border-bottom-width: 0; box-shadow: none; }
</style>
@endpush

{{-- 2. HTML CONTENT SECTION --}}
@section('content')
<div class="container-fluid py-4">
    <div class="d-flex align-items-center mb-5">
        <div class="bg-primary bg-opacity-10 p-2 rounded me-3 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
            <i class="bi bi-columns-gap text-primary fs-5"></i>
        </div>
        <h2 class="fw-bold mb-0 text-primary" style="letter-spacing: -0.5px;">Content Versioning</h2>
    </div>

    <div class="card border-0 bg-transparent shadow-none">
        <div class="table-responsive">
            <table class="table align-middle" id="posts-table" style="width: 100%;">
                <thead>
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="text-center pe-4">Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
@endsection

{{-- 3. JAVASCRIPT SECTION --}}
@push('scripts')
<script>
$(function() {
    // Objek Helper untuk merender elemen HTML
    const TableRenderer = {
        number: (meta) => `<span class="ps-3 text-secondary fw-bold">${meta.row + meta.settings._iDisplayStart + 1}</span>`,
        
        info: (row) => `
            <div>
                <div class="fw-bold text-dark mb-1">${row.title}</div>
                <div class="text-muted small">${row.excerpt ? row.excerpt.substring(0, 50) + '...' : 'Publish Description'}</div>
            </div>`,
        
        status: (data) => {
            const label = data || 'Draft';
            const cls = (label === 'Published') ? 'status-published' : 'status-draft';
            return `<span class="badge-status ${cls}">${label}</span>`;
        },
        
        date: (data) => `<span class="text-muted">${data ? moment(data).format('DD MMMM YYYY, HH:mm') : '28 April 2022, 16:00'}</span>`,
        
        action: () => `
            <div class="d-flex align-items-center justify-content-center pe-3">
                <button class="btn-restore" title="Restore"><i class="bi bi-arrow-repeat"></i></button>
                <button class="btn-expand"><i class="bi bi-chevron-down"></i></button>
            </div>`
    };

    // Inisialisasi DataTable
    $('#posts-table').DataTable({
        processing: true,
        serverSide: true,
        ordering: false, // Mematikan sortir
        ajax: '{{ route("admin.news.index") }}',
        dom: 'tp', // Tanpa Filter/Search
        language: { paginate: { previous: "<", next: ">" } },
        columns: [
            { data: null, render: (d, t, r, m) => TableRenderer.number(m) },
            { data: 'title', render: (d, t, r) => TableRenderer.info(r) },
            { data: 'status', render: (d) => TableRenderer.status(d) },
            { data: 'published_at', render: (d) => TableRenderer.date(d) },
            { data: null, className: 'text-center', render: () => TableRenderer.action() }
        ]
    });
});
</script>
@endpush