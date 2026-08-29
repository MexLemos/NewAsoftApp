<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #1a1a1a; }
        .header { background-color: #1e3a8a; color: white; padding: 16px 20px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { font-size: 16px; font-weight: bold; letter-spacing: 0.5px; }
        .header .meta { font-size: 9px; opacity: 0.85; text-align: right; }
        .header .company { font-size: 9px; opacity: 0.7; margin-top: 3px; }
        table { width: 100%; border-collapse: collapse; }
        thead tr { background-color: #1e3a8a; color: white; }
        thead th { padding: 8px 10px; text-align: left; font-size: 9.5px; font-weight: bold; letter-spacing: 0.3px; }
        tbody tr:nth-child(even) { background-color: #f1f5f9; }
        tbody tr:nth-child(odd) { background-color: #ffffff; }
        tbody td { padding: 7px 10px; border-bottom: 1px solid #e2e8f0; }
        .footer { margin-top: 20px; font-size: 8px; color: #64748b; text-align: center; border-top: 1px solid #e2e8f0; padding-top: 10px; }
        .count-badge { background-color: #f59e0b; color: #1e3a8a; font-weight: bold; padding: 2px 8px; border-radius: 20px; font-size: 8px; margin-left: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <h1>ASoftMedia <span class="count-badge">{{ count($rows) }} registos</span></h1>
            <div class="company">Sistema de Gestao Integrada</div>
        </div>
        <div class="meta">
            <div style="font-size:13px; font-weight:bold;">{{ $title }}</div>
            <div>Emitido em: {{ $date }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                @foreach($headings as $h)
                    <th>{{ $h }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $row)
            <tr>
                @foreach($row as $cell)
                    <td>{{ $cell }}</td>
                @endforeach
            </tr>
            @empty
            <tr>
                <td colspan="{{ count($headings) }}" style="text-align:center; padding: 20px; color:#64748b;">
                    Nenhum dado encontrado.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        ASoftMedia &mdash; Documento gerado automaticamente pelo sistema interno &mdash; {{ $date }}
    </div>
</body>
</html>
