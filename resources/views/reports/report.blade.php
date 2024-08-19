<!DOCTYPE html>
<html>
<head>
    <title>Report</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
        }
        h1, h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tbody tr:hover {
            background-color: #f1f1f1;
        }
        p {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <h1>{{$departmentName}} Report</h1>
    <p><strong>Department:</strong> {{ $department ?? 'N/A' }}</p>
    <p><strong>Scheme:</strong> {{ $scheme ?? 'N/A' }}</p>
    <p><strong>Distribution Type:</strong> {{ $distributionType ?? 'N/A' }}</p>
    <p><strong>Area Type:</strong> {{ $areaType ?? 'N/A' }}</p>

    <h2>Data:</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Department ID</th>
                <th>Scheme Name</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $beneficiary)
            <tr>
                <td>{{ $beneficiary->id }}</td>
                <td>{{ $beneficiary->department_id }}</td>
                <td>{{ $beneficiary->scheme_name }}</td>
                <td>{{ $beneficiary->created_at ? $beneficiary->created_at->format('Y-m-d H:i:s') : 'N/A' }}</td>
                <td>{{ $beneficiary->updated_at ? $beneficiary->updated_at->format('Y-m-d H:i:s') : 'N/A' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center;">No data available</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
