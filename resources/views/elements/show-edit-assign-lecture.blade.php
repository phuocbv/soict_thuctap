<div class="form-group">
    <label>Công ty phân công: {{ $lectureAssignCompany->company->name }}</label>
</div>
<div class="form-group">
    <label>Giảng viên hiện tại: {{ $lectureAssignCompany->lecture->name }}</label>
</div>
<input type="hidden" name="companyId" value="{{ $lectureAssignCompany->company->id }}">
<input type="hidden" name="lectureAssignCompanyId" value="{{ $lectureAssignCompany->id }}">
<div class="form-group">
    <label for="mssv">Chọn giảng viên thay thế</label>
    <select class="form-control" name="lectureId" required>
        <option value="">Chọn giảng viên</option>
        @foreach ($listLecture as $lecture)
            <option value="{{ $lecture->id }}">{{ $lecture->name }}</option>
        @endforeach
    </select>
</div>
