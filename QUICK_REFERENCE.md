# CBT v3 - Quick Reference Guide

## 🚀 Project at a Glance

**Status**: ✅ Phase 1 & 2 Complete
**Framework**: Laravel 12
**Admin Panel**: Complete with Blade Templates + Tailwind CSS
**API**: 21 RESTful endpoints
**Roles**: 7 (with 40+ permissions)
**Git Commits**: 20 total

---

## 📍 What's Where

### Controllers
```
app/Http/Controllers/
├── Admin/
│   ├── DashboardController.php          → admin dashboard analytics
│   ├── ExamController.php               → exam CRUD + results
│   ├── QuestionGroupController.php      → question group CRUD
│   ├── QuestionController.php           → question CRUD
│   ├── MobileAppSettingController.php   → mobile settings
│   └── QuestionImportController.php     → file import handling
└── API/
    ├── AuthController.php
    ├── ExamController.php
    └── MobileAppController.php
```

### Views
```
resources/views/
├── layouts/admin.blade.php              → master layout with sidebar
└── admin/
    ├── dashboard.blade.php              → analytics dashboard
    ├── exams/
    │   ├── index.blade.php              → exam list with search
    │   ├── create.blade.php             → exam creation form
    │   ├── edit.blade.php               → exam editing form
    │   ├── show.blade.php               → exam details
    │   ├── results.blade.php            → exam results dashboard
    │   └── mobile-settings.blade.php    → mobile app config (3 tabs)
    ├── question-groups/
    │   ├── index.blade.php              → group list per exam
    │   ├── create.blade.php             → group creation form
    │   └── edit.blade.php               → group editing form
    └── questions/
        ├── index.blade.php              → question list per group
        ├── create.blade.php             → question creation form
        └── edit.blade.php               → question editing form
```

### Models (17 total)
```
app/Models/
├── Exam.php
├── ExamQuestion.php
├── ExamParticipant.php
├── ExamSubmission.php
├── ExamParticipantAnswer.php
├── ExamEssayGrade.php
├── ExamAnalytic.php
├── ExamQuestionPool.php
├── Question.php
├── QuestionGroup.php
├── QuestionOption.php
├── QuestionPerformance.php
├── MobileAppSetting.php
├── CBTActivityLog.php
├── ExternalUserMapping.php
├── ImportJob.php
└── ImportLog.php
```

### Services
```
app/Services/
├── ExamService.php
├── MobileAppService.php
└── Import/
    ├── WordImporter.php
    ├── TxtImporter.php
    └── BlackboardImporter.php
```

---

## 🎯 Main Routes

### Admin Routes (use `route()` helper)
```php
// Dashboard
route('admin.dashboard')

// Exams
route('admin.exams.index')
route('admin.exams.create')
route('admin.exams.show', $exam)
route('admin.exams.edit', $exam)
route('admin.exams.destroy', $exam)
route('admin.exams.results', $exam)

// Question Groups
route('admin.question-groups.index', $exam)
route('admin.question-groups.create', $exam)
route('admin.question-groups.edit', $group)
route('admin.question-groups.update', $group)
route('admin.question-groups.destroy', $group)

// Questions
route('admin.questions.index', $group)
route('admin.questions.create', $group)
route('admin.questions.edit', $question)
route('admin.questions.update', $question)
route('admin.questions.destroy', $question)

// Mobile Settings
route('admin.exams.mobile-settings', $exam)
route('admin.mobile-settings.update', $exam)
```

---

## 📊 Database Quick Reference

### Key Tables
```sql
exams              -- Main exam records
questions          -- Question records
question_groups    -- Question organization
exam_participants  -- Student enrollments
exam_submissions   -- Submitted answers
mobile_app_settings-- Mobile config
cbt_activity_logs  -- Audit trail
```

### Model Queries
```php
// Get exam with all relationships
$exam = Exam::with('questionGroups.questions', 'participants', 'mobileSettings')->find($id);

// Get questions for group
$questions = $group->questions()->with('options')->paginate(15);

// Get exam results
$results = $exam->participants()->with('user')->get();

// Get activity logs
$logs = $exam->activityLogs()->latest()->paginate(10);
```

---

## 🎨 UI Components Quick Guide

### Forms in Views
```blade
<!-- Text Input -->
<input type="text" name="name" value="{{ old('name', $model->name) }}" 
       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">

<!-- Textarea -->
<textarea name="content" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
  {{ old('content', $model->content) }}
</textarea>

<!-- Select -->
<select name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
  <option value="test" {{ old('type', $model->type) === 'test' ? 'selected' : '' }}>Test</option>
</select>

<!-- Checkbox -->
<input type="checkbox" name="published" value="1" {{ old('published', $model->published) ? 'checked' : '' }}>

<!-- Error Display -->
@error('field')
  <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
@enderror
```

### Common Styling Classes
```css
/* Buttons */
.bg-blue-500 .text-white .px-6 .py-2 .rounded-lg .hover:bg-blue-600

/* Cards */
.bg-white .rounded-lg .shadow-sm .border .border-gray-200 .p-6

/* Badges */
.inline-block .px-2 .py-1 .rounded-full .text-xs .font-medium
  .bg-blue-100 .text-blue-800  /* blue */
  .bg-green-100 .text-green-800  /* green */
  .bg-yellow-100 .text-yellow-800  /* yellow */

/* Tables */
.table-auto .w-full .border-collapse
```

---

## 🔒 Authorization & Roles

### Roles
```
1. Super Admin      - Full system access
2. Admin CBT        - Exam and question management
3. Operator CBT     - Exam monitoring and grading
4. GTK              - Data validation
5. Kepala Madrasah  - Reporting and approval
6. WAKA             - Class management
7. Siswa            - Take exams
```

### Using Permissions
```php
// In controllers
$this->authorize('create', Exam::class);

// In views
@can('edit', $exam)
  Edit button
@endcan

// In routes
Route::middleware('can:create,App\Models\Exam')...
```

---

## 🛠️ Common Development Tasks

### Add New Exam Field
1. Add to migration
2. Add to fillable in Exam model
3. Add to validation in ExamController
4. Add to form in create/edit view
5. Display in show view

### Add New Question Type
1. Add to QUESTION_TYPES in Question model (if needed)
2. Update validation
3. Update question form
4. Handle in ExamService

### Add New Mobile Setting
1. Add column to mobile_app_settings table
2. Add to MobileAppSetting model fillable
3. Add to mobile settings form
4. Handle in MobileAppService

---

## 🧪 Testing Commands

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/ExamTest.php

# Run with coverage
php artisan test --coverage
```

---

## 🚨 Common Issues & Fixes

### Form not submitting
- Check CSRF token: `@csrf`
- Check form method: POST, PUT, DELETE
- Check action route is correct

### Model not found
- Use route model binding: `{exam}` parameter
- Import model in controller: `use App\Models\Exam;`
- Check model exists before accessing

### Validation errors not showing
- Include `@error('field')` in view
- Pass data back with `withErrors()`
- Check form method matches validation

### Routes not working
- Run `php artisan route:clear`
- Check route is defined in `routes/admin.php`
- Use `route()` helper, not hardcoded URLs

---

## 📈 Performance Tips

1. **Use with() for eager loading**
   ```php
   $exams = Exam::with('creator', 'participants')->get();
   ```

2. **Paginate large datasets**
   ```php
   $questions = $group->questions()->paginate(15);
   ```

3. **Cache frequently accessed data**
   ```php
   Cache::remember('exams', 3600, fn() => Exam::all());
   ```

4. **Index database columns used in queries**
   Already done in migration!

---

## 📚 File Organization

```
Keep similar files together:
- Views for same feature in same directory
- Controllers for same module together
- Related models near each other
- Services for same functionality in Services folder
```

---

## 🔍 Useful Commands

```bash
# Generate new migration
php artisan make:migration create_table_name --create=table_name

# Generate new model
php artisan make:model ModelName -m  # with migration

# Generate new controller
php artisan make:controller Admin/ControllerName --model=Model

# Clear caches
php artisan cache:clear
php artisan route:clear
php artisan config:clear
php artisan view:clear

# Database commands
php artisan migrate
php artisan migrate:rollback
php artisan db:seed
php artisan tinker
```

---

## 🎯 Next Development Steps

To continue development:

1. **Create Question Options UI**
   - QuestionOptionController
   - question-options/create.blade.php
   - question-options/edit.blade.php

2. **Create Activity Logs View**
   - ActivityLogController
   - activity-logs/index.blade.php

3. **Create Student Exam Interface**
   - Student routes (not admin)
   - exam/show.blade.php (student view)
   - exam/question.blade.php

4. **Add Advanced Features**
   - Real-time exam timer
   - Question review functionality
   - Instant answer validation
   - Progress indicators

---

## 📞 Quick Help

**Need to understand a feature?**
1. Check `PHASE_2_COMPLETION_REPORT.md` for details
2. Look at the controller method
3. Review the Blade template
4. Check related model methods

**Need to add something new?**
1. Create model if needed
2. Create migration if database change
3. Create controller with CRUD methods
4. Create Blade views
5. Add routes
6. Test thoroughly

---

## 🌟 Key Features Summary

✅ Complete admin panel with dashboard
✅ Exam creation and management
✅ Question group and question management
✅ Mobile app security configuration
✅ Results and analytics
✅ RBAC with 7 roles
✅ API with Sanctum authentication
✅ Question import system
✅ Professional UI with Tailwind CSS
✅ Responsive design
✅ Form validation and error handling
✅ Activity logging
✅ Mobile app integration ready

---

**Last Updated**: Phase 2 Completion
**Repository**: https://github.com/chandra35/cbtv3
**Status**: Production Ready
