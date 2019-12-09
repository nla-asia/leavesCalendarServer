<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Leaves Calendar</title>

    </head>
    <body>
    <table border="1" borderCollapse="collapse" cellspacing="0">
        <thead>
            <tr>
            <th>ID</th>
            <th>Employee Name</th>
            <th>Leave Type</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Reason</th>
            </tr>
        </thead>
        <tbody>
            @foreach($leaves as $leave)
            <tr>
                <td>{{ $leave->id }}</td>
                <td>{{ $leave->employee_name }}</td>
                <td>{{ $leave->leave_name }}</td>
                <td>{{ $leave->start_date }}</td>
                <td>{{ $leave->end_date }}</td>
                <td>{{ $leave->reason }}</td>
            </tr>
            @endforeach
        </tbody>
        </table>
   

    </body>
</html>
