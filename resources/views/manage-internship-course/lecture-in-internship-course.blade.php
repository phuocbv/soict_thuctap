@foreach ($listInternshipGroup as $companyId => $listGroup)
    @php
        $listGroupSubject = $listGroup->groupBy('subject');
    @endphp
    @foreach($listGroupSubject as $key => $listG)
    <div class="table-responsive student-assign">
        <table id="student-result" class="table table-bordered">
            <thead>
                <tr>
                    {{--<th><input type="checkbox" name="selectAll" class="selectAll"></th>--}}
                    <th>Môn học</th>
                    <th style="min-width: 64px">Mã sinh viên</th>
                    <th style="min-width: 80px">Tên sinh viên</th>
                    <th style="min-width: 100px">Công ty phân công</th>
                    <th style="min-width: 100px">Môn học</th>
                </tr>
            </thead>
            <tfoot>
            <tr>
                {{--<th>--}}
                    {{--<a href="#" id="print-many-report">--}}
                        {{--<span class="glyphicon glyphicon-print"></span>--}}
                    {{--</a>--}}
                {{--</th>--}}
                <th colspan="4">
                    <a href="javascript:void(0)" class="print-lecture-in-course" data-lecture-id="{{ $listGroup->first()->lecture_id }}"
                        data-internship-course-id="{{ $listGroup->first()->internship_course_id }}"
                        data-course-term="{{ $key }}"
                        data-company-id="{{ $companyId }}">
                        <span class="glyphicon glyphicon-print"></span>
                    </a>
                </th>
            </tr>
            </tfoot>
            <tbody>
                @foreach ($listG as $group)
                    <tr>
                        {{--<td><input type="checkbox" name="select[]" id="" class="select" value="{{$group->id}}"></td>--}}
                        <td>{{ $key }}</td>
                        <td>{{ $group->student->msv }}</td>
                        <td>{{ $group->student->name }}</td>
                        <td>{{ $group->company->name }}</td>
                        <td>{{ $group->subject }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endforeach
@endforeach
