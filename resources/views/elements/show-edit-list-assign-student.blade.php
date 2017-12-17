<input type="hidden" name="listInternshipGroupId" value="{{ json_encode($listInternshipGroupId) }}">
<div class="form-group">
    <label>Danh sách sinh viên</label>
</div>
<div class="form-group">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Mã sinh viên</th>
                <th>Tên sinh viên</th>
                <th>Khóa</th>
                <th>Chương trình</th>
            </tr>
        </thead>
        <tbody>
            @foreach($listInternshipGroup as $internshipGroup)
                <tr>
                    <td>{{ $internshipGroup->student->msv }}</td>
                    <td>{{ $internshipGroup->student->name }}</td>
                    <td>{{ $internshipGroup->student->grade }}</td>
                    <td>{{ $internshipGroup->student->program_university }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="form-group">
    <label for="mssv">Chọn công ty</label>
    <select class="form-control" name="companyId" required>
        <option value="">Chọn công ty</option>
        @foreach ($listCompany as $company)
            <option value="{{ $company->company_id }}">{{ $company->company->name }}</option>
        @endforeach
    </select>
</div>
