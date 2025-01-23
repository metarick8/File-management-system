<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Group Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
        }
        .info-block {
            margin-bottom: 20px;
        }
        .info-block h2 {
            margin-top: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <h1>Group Information</h1>

    <div class="info-block">
        <h2>Name:</h2>
        <p>{{ isset($data['group']['Name']) ? $data['group']['Name'] : 'N' }}</p>
    </div>

    <div class="info-block">
        <h2>Description:</h2>
        <p>{{ isset($data['group']['Description']) ? $data['group']['Description'] : 'N' }}</p>
    </div>

    <div class="info-block">
        <h2>Group:</h2>
        <p>{{ isset($data['group']['Group']) ? $data['group']['Group'] : 'N' }}</p>
    </div>

    <div class="info-block">
        <h2>Created At:</h2>
        <p>{{ isset($data['group']['Created at']) ? $data['group']['Created at']->format('Y-m-d H:i:s') : 'N' }}</p>
    </div>

    <div class="info-block">
        <h2>Members:</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Files Edited</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($data['Members']) && count($data['Members']))
                    @foreach($data['Members'] as $member)
                        <tr>
                            <td>{{ $member['Name'] }}</td>
                            <td>{{ $member['Email'] }}</td>
                            <td>
                                @if(count($member['Files edited']))
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Owner</th>
                                                <th>Status</th>
                                                <th>Created At</th>
                                                <th>Versions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($member['Files edited'] as $file)
                                                <tr>
                                                    <td>{{ $file['Name'] }}</td>
                                                    <td>{{ $file['Owner'] }}</td>
                                                    <td>{{ $file['Status'] }}</td>
                                                    <td>{{ $file['Created at']->format('Y-m-d H:i:s') }}</td>
                                                    <td>
                                                        @if(isset($file['Versions']))
                                                            {{ implode(', ', array_map(function($version) { return $version['Version num']; }, $file['Versions'])) }}
                                                        @else
                                                            No versions available
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    No files edited by this member
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    No members found
                @endif
            </tbody>
        </table>
    </div>
</body>
</html>
