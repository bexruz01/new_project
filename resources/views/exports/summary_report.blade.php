
<table>
    <thead>
    <tr>
        {{-- <th> No </th> --}}
        <th> FullName </th>
        @foreach($subjects as $subject)
            <th>{{ $subject['name'] }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    {{-- {{$i = 1;}} --}}
    @foreach($students as $student)
        <tr>
            {{-- <td>{{ $i++ }}</td> --}}
            <td>{{ $student['full_name'] }}</td>
            @foreach ($student['exam_rating'] as $exam)
                <td>{{ $exam['rating'] }} [{{$exam['position']}}]</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
