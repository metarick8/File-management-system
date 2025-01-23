<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>File Information</title>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h2 {
            text-align: center;
        }
        .info-box {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>File Information</h2>

    @if (!empty($data[0]))
        <div class="info-box">
            <h3>Name</h3>
            <p>{{ $data[0]['Name'] }}</p>
        </div>

        <div class="info-box">
            <h3>Owner</h3>
            <p>{{ $data[0]['Owner'] }}</p>
        </div>

        <div class="info-box">
            <h3>Group</h3>
            <p>{{ $data[0]['Group'] }}</p>
        </div>

        <div class="info-box">
            <h3>Status</h3>
            <p>{{ $data[0]['Status'] }}</p>
        </div>

        <div class="info-box">
            <h3>Created At</h3>
            <p>{{ $data[0]['Created at'] }}</p>
        </div>

        @if (!empty($data[0]['Versions']))
            <div class="info-box">
                <h3>Versions</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Editor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data[0]['Versions'] as $version)
                            <tr>
                                <td>{{ $version['Editor'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="info-box">
                <h3>Versions</h3>
                <p>No versions yet</p>
            </div>
        @endif
    @endif
</body>
</html>
