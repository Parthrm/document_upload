<!DOCTYPE html>
<html>
<head>
    <title>Report</title>
    <style>
        /*  TODO Better CSS here */
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
        th{
            padding: 0.5rem 0.75rem 0.5rem 0.75rem;
            text-align: left;
        }
        td{
            padding: 0rem 0.25rem 0rem 0.25rem;
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
    <h1 style="text-align: center; text-decoration: underline;" >Report Generation</h1>
    <p><strong>Department:</strong> {{ $departmentName ?? 'N/A' }}</p>
    <p><strong>Scheme:</strong> {{ $schemeName ?? 'N/A' }}</p>
    <p><strong>Distribution Type:</strong> {{ $distributionType ?? 'N/A' }}</p>
    <p><strong>Area Type:</strong> {{ $areaType ?? 'N/A' }}</p>
    
    <h2 style="page-break-after: always;" >Data:</h2>
    <table>
        <thead>
            <tr>
                <th>Sr No.</th>
                <th>Name</th>
                <th>District</th>
                <th>Taluka</th>
                <th>Scheme Name</th>
                <th>Department Name</th>
            </tr>
        </thead>
        TODO make the right columns to appear  
        <tbody>
            {{$i=1}}
            @forelse ($data as $beneficiary)
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $beneficiary->name }}</td>
                <td>{{ $beneficiary->district }}</td>
                <td>{{ $beneficiary->taluka }}</td>
                <td>{{ $schemeName }}</td>
                <td>{{ $departmentName }}</td>
                {{$i+=1}}
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
