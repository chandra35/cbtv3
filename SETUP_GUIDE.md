# CBT v3 - Computer-Based Testing System

## Overview

CBT v3 adalah sistem Computer-Based Testing yang dirancang khusus untuk integrasi dengan SIMANSA dan PPDB. Sistem ini mendukung:

- ✅ Exam management dengan multiple jenjang pendidikan (SD, SMP, SMA, Madrasah)
- ✅ Per-user randomized questions untuk prevent cheating
- ✅ Flexible question types (MC, True/False, Essay, Matching, Fill in the Blank)
- ✅ Mobile app dengan anti-cheating features (screenshot detection, app-switch detection, idle timeout)
- ✅ Admin panel untuk password management, device/IP whitelisting
- ✅ Question import dari Word, TXT, Blackboard formats
- ✅ RBAC dengan 7 roles dan 40+ permissions
- ✅ Comprehensive activity logging dan suspicious activity tracking

## Project Structure

```
cbtv3/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Api/
│   │       │   ├── AuthController.php      # Login, validateExamPassword
│   │       │   ├── ExamController.php      # Exam flow (list, detail, start, answer, submit)
│   │       │   └── MobileAppController.php # Mobile-specific (device validation, anti-cheating)
│   │       └── Admin/
│   │           ├── ExamController.php           # Admin exam management, CRUD, publishing
│   │           ├── MobileAppSettingController.php # Password, device/IP whitelist
│   │           └── QuestionImportController.php  # Import Word/TXT/Blackboard
│   ├── Models/
│   │   ├── Exam.php                     # Core exam entity
│   │   ├── Question.php                 # Question bank
│   │   ├── QuestionGroup.php            # Grouped questions with randomization
│   │   ├── ExamParticipant.php          # Track user attempts
│   │   ├── ExamSubmission.php           # Answer tracking & auto-scoring
│   │   ├── MobileAppSetting.php         # Anti-cheating & password config
│   │   ├── CBTActivityLog.php           # Activity audit trail
│   │   ├── QuestionOption.php           # MC/True-False/Matching options
│   │   ├── ExamQuestion.php             # Exam-to-Question relationship
│   │   ├── UserExamQuestion.php         # Per-user question assignment
│   │   ├── ExamEssayGrade.php           # Manual grading for essays
│   │   ├── ExamQuestionPool.php         # Random selection pools
│   │   ├── ExamAnalytic.php             # Statistics
│   │   ├── QuestionPerformance.php      # Question-level metrics
│   │   ├── ExternalUserMapping.php      # SIMANSA/PPDB integration
│   │   ├── ImportJob.php                # Import tracking
│   │   └── ImportLog.php                # Import error logs
│   ├── Services/
│   │   ├── ExamService.php              # Exam flow business logic
│   │   ├── MobileAppService.php         # Mobile security & anti-cheating
│   │   └── Import/
│   │       ├── WordImporter.php         # .docx parsing
│   │       ├── TxtImporter.php          # .txt parsing
│   │       └── BlackboardImporter.php   # Blackboard QTI XML parsing
│   └── Providers/
│       └── PermissionProvider.php       # Spatie Permission setup
├── database/
│   └── migrations/
│       └── 2026_02_06_073331_create_cbt_base_tables.php
├── routes/
│   ├── api.php    # API v1 routes (auth, exams, mobile)
│   ├── admin.php  # Admin panel routes (CRUD, settings, import)
│   └── web.php    # Web app routes
├── resources/views/
│   ├── admin/     # Admin panel views (to be created)
│   └── layouts/   # Layout templates
├── storage/
│   └── imports/   # Temporary import files
└── .env           # Configuration (DB, mail, etc)
```

## Database Schema

### Main Tables

1. **exams**
   - exam_name, exam_type, description
   - jenjang (SD, SMP, SMA, Madrasah)
   - duration (minutes), passing_grade
   - start_date, end_date, start_time, end_time
   - is_published, user_id (creator)

2. **question_groups**
   - exam_id, name, description
   - randomize_questions, randomize_options (boolean)
   - order_index
   - created_by

3. **questions**
   - question_group_id, user_id (creator)
   - content, question_type (enum)
   - points, difficulty_level
   - image_url, instructions, explanation

4. **question_options**
   - question_id, content, order_index
   - is_correct (for MC, True/False)
   - image_url

5. **exam_participants**
   - exam_id, user_id, attempt_number (unique)
   - status (not_started, in_progress, submitted, graded, completed)
   - score, percentage
   - started_at, submitted_at
   - source_system (cbt_internal, simansa, ppdb)

6. **exam_submissions**
   - exam_participant_id, question_id
   - user_answer (text/JSON)
   - is_correct (auto-filled for MC)
   - points_earned
   - submitted_at

7. **mobile_app_settings**
   - exam_id
   - enable_password_protection, exam_password_hash
   - max_idle_time (seconds)
   - prevent_screenshot, prevent_screen_recording
   - prevent_app_switching
   - enable_camera_monitoring, require_face_detection
   - disable_copy_paste, disable_dev_tools
   - lock_device_orientation
   - allowed_ips, allowed_devices (JSON)

8. **cbt_activity_logs**
   - exam_participant_id, user_id
   - action (enum: login, start_exam, view_question, submit_answer, app_switched, screenshot_attempt, suspicious_activity)
   - ip_address, user_agent
   - details (JSON)

9. **user_exam_questions**
   - exam_participant_id, question_id
   - order_in_exam
   - randomized_at
   - marked_for_review

### Supporting Tables

- **question_options** - MC/matching options
- **exam_questions** - Exam to Question mapping with override points
- **exam_essay_grades** - Manual grading results
- **exam_question_pools** - Random selection pools
- **exam_analytics** - Summary statistics
- **question_performance** - Question-level metrics
- **external_user_mappings** - SIMANSA/PPDB integration
- **import_jobs** - Import tracking (Word/TXT/Blackboard)
- **import_logs** - Import error logs

## API Endpoints

### Authentication (Public)

```
POST /api/v1/auth/login
  Request: { username/email, password }
  Response: { access_token, user }

POST /api/v1/auth/login-mobile
  Request: { username/email, password, device_id, device_name, device_model, os_type, os_version }
  Response: { access_token, user, device_info }

POST /api/v1/auth/validate-exam-password
  Request: { exam_id, password }
  Response: { valid: boolean }

POST /api/v1/auth/logout
  Response: { success: true }

GET /api/v1/auth/me
  Response: { user }
```

### Exam Flow (Protected)

```
GET /api/v1/exams
  Response: [ { exam info } ]

GET /api/v1/exams/{exam}
  Response: { exam details }

POST /api/v1/exams/{exam}/start
  Request: { device_id }
  Response: { participant_id, total_questions, duration_minutes }

GET /api/v1/exams/{exam}/status
  Response: { total_questions, answered_count, progress_percentage, remaining_seconds }

GET /api/v1/exams/{exam}/questions
  Response: [ { question with order, is_answered, is_marked } ]

GET /api/v1/exams/{exam}/questions/{question}
  Response: { question details, options, submitted_answer, marked_for_review }

POST /api/v1/exams/{exam}/answer
  Request: { question_id, answer }
  Response: { is_correct, points_earned }

POST /api/v1/exams/{exam}/mark-review
  Request: { question_id }
  Response: { success: true }

POST /api/v1/exams/{exam}/submit
  Response: { score, percentage, passed, result_message }

GET /api/v1/exams/{exam}/results
  Response: { score, percentage, passed, answer_review (if allowed) }
```

### Mobile App Security (Protected)

```
GET /api/v1/mobile/settings?exam_id={exam}
  Response: { all mobile settings, password_required, anti_cheat_config }

POST /api/v1/mobile/validate-device
  Request: { exam_id, device_id, device_ip }
  Response: { valid: boolean, whitelisted: boolean }

POST /api/v1/mobile/track-activity
  Request: { action, details, ip_address, user_agent }
  Response: { logged: true }

POST /api/v1/mobile/track-app-switch
  Request: { exam_id }
  Response: { cheating_flagged: boolean }

POST /api/v1/mobile/track-screenshot
  Request: { exam_id }
  Response: { cheating_flagged: boolean }

POST /api/v1/mobile/heartbeat
  Request: { exam_id, last_activity_time }
  Response: { valid: boolean, remaining_seconds, idle_timeout_exceeded: boolean }

GET /api/v1/mobile/anti-cheat-config/{exam}
  Response: { all anti-cheating settings }
```

## Admin Panel Routes

```
GET  /admin/exams              # List exams
GET  /admin/exams/create       # Create exam form
POST /admin/exams              # Store exam
GET  /admin/exams/{exam}       # View exam
GET  /admin/exams/{exam}/edit  # Edit form
PUT  /admin/exams/{exam}       # Update exam
DELETE /admin/exams/{exam}     # Delete exam
POST /admin/exams/{exam}/publish   # Publish
POST /admin/exams/{exam}/unpublish # Unpublish
GET  /admin/exams/{exam}/results   # View results

GET  /admin/exams/{exam}/mobile-settings  # Settings form
PUT  /admin/exams/{exam}/mobile-settings  # Update settings
POST /admin/exams/{exam}/mobile-settings/generate-password  # Generate password
POST /admin/exams/{exam}/mobile-settings/reset-password     # Reset password

POST /admin/exams/{exam}/mobile-settings/ip-whitelist       # Add IP
DELETE /admin/exams/{exam}/mobile-settings/ip-whitelist     # Remove IP

POST /admin/exams/{exam}/mobile-settings/device-whitelist   # Add device
DELETE /admin/exams/{exam}/mobile-settings/device-whitelist # Remove device

GET /admin/exams/{exam}/activity-logs       # View all activities
GET /admin/exams/{exam}/suspicious-activities # View suspicious activities

GET  /admin/groups/{group}/import           # Import form
POST /admin/groups/{group}/import           # Process import
GET  /admin/groups/{group}/imports          # Import history
GET  /admin/imports/{importJob}             # Import details
DELETE /admin/imports/{importJob}/questions # Delete imported questions
```

## Service Classes

### ExamService

**Purpose**: Core exam flow and question management

**Key Methods**:
- `startExam(ExamParticipant)` - Initialize exam, generate user-specific questions
- `generateQuestionsForParticipant(ExamParticipant)` - Create randomized question set per user
- `submitAnswer(ExamParticipant, $questionId, $answer)` - Process answer, auto-score MC
- `submitExam(ExamParticipant)` - Calculate final score and percentage
- `markForReview(ExamParticipant, $questionId)` - Bookmark question
- `getExamStatus(ExamParticipant)` - Return progress metrics
- `checkMultipleChoiceAnswer(Question, $optionId)` - Private MC validation

### MobileAppService

**Purpose**: Mobile app security, anti-cheating, session management

**Key Methods**:
- `validateExamPassword(MobileAppSetting, $password)` - Check password match
- `setExamPassword(MobileAppSetting, $password)` - Set password
- `resetExamPassword(MobileAppSetting)` - Clear password
- `trackAppSwitch(ExamParticipant)` - Detect app switching, flag cheating
- `trackScreenshot(ExamParticipant)` - Detect screenshot, flag cheating
- `checkIdleTimeout(ExamParticipant, $lastActivityTime)` - Auto-submit if idle
- `isIPAllowed(MobileAppSetting, $ip)` - Validate IP whitelist
- `isDeviceAllowed(MobileAppSetting, $deviceId)` - Validate device whitelist
- `add/removeIPWhitelist()` - Manage IP list
- `add/removeDeviceWhitelist()` - Manage device list
- `getAntiCheatConfig(MobileAppSetting)` - Return all security settings

### Import Services

**WordImporter**: Parse .docx files
- Expected format: [1] Question text? a) Option... Jawaban: a

**TxtImporter**: Parse .txt files
- Same format as Word

**BlackboardImporter**: Parse Blackboard QTI XML exports
- Extracts questions, options, correct answers from XML structure

## Key Features

### 1. Per-User Randomized Questions

```php
// Each student gets different question order/selection
$this->examService->generateQuestionsForParticipant($participant);
```

Features:
- Random question selection from pools
- Random option order per student
- Optional question shuffling per group

### 2. Anti-Cheating Features

**Mobile App Protection**:
- Password protection (configurable from admin)
- Device IP whitelist
- Device ID whitelist
- App-switch detection
- Screenshot detection
- Idle timeout (auto-submit)
- Camera monitoring (optional)
- Disable copy/paste
- Lock device orientation

**Monitoring**:
- Comprehensive activity logging
- Suspicious activity flagging
- User agent tracking
- IP address logging

### 3. Question Import

Supported formats:
- Microsoft Word (.docx)
- Plain Text (.txt)
- Blackboard QTI XML exports

Import features:
- Batch question creation
- Automatic option mapping
- Correct answer detection
- Import history tracking
- Rollback capability

### 4. Role-Based Access Control

Roles (via Spatie Permission):
- Super Admin - Full system access
- Admin CBT - Exam creation and management
- Operator CBT - Question management and grading
- GTK - View own exam results
- Kepala Madrasah - Dashboard and reporting
- WAKA - Dashboard and reporting
- Siswa - Take exams

## Authentication

### API Authentication

Uses Laravel Sanctum for token-based authentication:

```php
// Mobile login creates device-specific token
$user = User::where('email', $request->email)->firstOrFail();
$token = $user->createToken(
    'device-' . $request->device_id,
    ['exam:read', 'exam:submit']
)->plainTextToken;
```

### Mobile Device Tracking

Each login tracks:
- device_id (unique device identifier)
- device_name
- device_model
- os_type (iOS, Android)
- os_version
- device_ip

Used for IP/device whitelisting validation.

## Integration with SIMANSA & PPDB

### ExternalUserMapping Model

Maps CBT users to external systems:
- external_system: 'simansa' | 'ppdb'
- external_user_id: ID from source system
- user_id: CBT user ID

Allows syncing student data and cross-system participation tracking.

## Setup Instructions

### Prerequisites

- PHP 8.1+
- MySQL 8.0+
- Composer

### Installation

1. Clone repository
```bash
git clone https://github.com/chandra35/cbtv3.git
cd cbtv3
```

2. Install dependencies
```bash
composer install
```

3. Setup environment
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure database in `.env`
```
DB_DATABASE=cbtv3
DB_USERNAME=root
DB_PASSWORD=
```

5. Run migrations
```bash
php artisan migrate
```

6. Setup Spatie Permission
```bash
php artisan db:seed --class=PermissionSeeder
```

7. Create admin user
```bash
php artisan make:user admin
```

8. Start development server
```bash
php artisan serve
```

## Testing

### Unit Tests
```bash
php artisan test
```

### API Testing (Postman collection included)
```
tests/api/cbtv3-collection.postman_collection.json
```

## Deployment

### Production Setup

1. Install dependencies
```bash
composer install --no-dev --optimize-autoloader
```

2. Cache configuration
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

3. Run migrations
```bash
php artisan migrate --force
```

4. Generate API documentation
```bash
php artisan api:docs
```

### Environment Variables (Production)

```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://cbt.example.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cbtv3_prod
DB_USERNAME=cbtv3_user
DB_PASSWORD=strong_password

MAIL_MAILER=smtp
MAIL_HOST=mail.example.com
MAIL_PORT=587
MAIL_USERNAME=noreply@example.com
MAIL_PASSWORD=email_password

SESSION_DRIVER=cookie
CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
```

## File Uploads

- Question images: `storage/app/public/questions/`
- Exam documents: `storage/app/public/exams/`
- Import files: `storage/app/imports/` (temporary)
- Activity logs: Stored in database

Configure in `config/filesystems.php`:
```php
'local' => [
    'driver' => 'local',
    'root' => storage_path('app'),
],
'public' => [
    'driver' => 'local',
    'root' => storage_path('app/public'),
    'url' => env('APP_URL').'/storage',
],
```

## Security Considerations

1. **Input Validation**: All API inputs validated with Laravel validation rules
2. **Password Hashing**: All passwords hashed with bcrypt
3. **Rate Limiting**: API endpoints have rate limiting (60 requests/minute)
4. **CSRF Protection**: Web routes protected with CSRF tokens
5. **SQL Injection**: All queries use parameterized statements (Eloquent ORM)
6. **XSS Protection**: All outputs escaped properly in views
7. **Session Security**: Secure session cookies with HttpOnly, SameSite attributes
8. **API Token Expiry**: Sanctum tokens can be configured with expiry

## Troubleshooting

### Database Migration Issues

If migrations fail:

```bash
# Fresh start (wipes data)
php artisan migrate:fresh

# Or specific migration
php artisan migrate:refresh --path=database/migrations/2026_02_06_073331_create_cbt_base_tables.php
```

### Model Not Found

Ensure all models are in correct namespace:
```php
namespace App\Models;
```

### Permission Issues

Reset permissions:
```bash
php artisan db:seed --class=PermissionSeeder
```

### Mobile App Connection Issues

1. Check API_BASE_URL in mobile app config
2. Verify CORS headers in `config/cors.php`
3. Check API authentication token validity
4. Review activity logs for connection errors

## Development Roadmap

### Phase 1 ✅ (Complete)
- Core models and relationships
- Exam service and business logic
- Mobile app service with anti-cheating
- API endpoints (Auth, Exam, Mobile)
- Admin controllers (basic structure)
- Question import services
- RBAC setup

### Phase 2 (In Progress)
- Admin panel views (Blade templates)
- Question bank management UI
- Mobile settings UI with dashboard
- Activity monitoring dashboard
- Import progress UI

### Phase 3 (Planned)
- Essay grading workflow
- Analytics dashboard with charts
- Student performance reporting
- Export to Excel/PDF
- SIMANSA integration endpoint
- PPDB integration endpoint
- Mobile app (Flutter/React Native)
- Push notifications

### Phase 4 (Planned)
- Advanced randomization strategies
- Question difficulty adaptation
- Proctoring system (video recording)
- Plagiarism detection
- Advanced analytics (heat maps, time analysis)
- API v2 with GraphQL

## Support & Contribution

- Issues: https://github.com/chandra35/cbtv3/issues
- Documentation: This README.md
- Contribution: Follow PSR-12 coding standards

## License

Proprietary - Education System Integration
