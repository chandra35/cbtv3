# CBT v3 - Quick Start Guide

## Installation (5 minutes)

### 1. Clone & Setup
```bash
git clone https://github.com/chandra35/cbtv3.git
cd cbtv3
composer install
cp .env.example .env
php artisan key:generate
```

### 2. Database Configuration
Edit `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cbtv3
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Database Setup
```bash
php artisan migrate
php artisan db:seed --class=PermissionSeeder
```

### 4. Run Development Server
```bash
php artisan serve
```

Server runs on: `http://localhost:8000`

---

## API Quick Test (Postman/cURL)

### 1. Login & Get Token
```bash
curl -X POST http://localhost:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@example.com",
    "password": "password"
  }'
```

Response:
```json
{
  "access_token": "1|abcdef123456...",
  "user": {
    "id": 1,
    "name": "Admin User",
    "email": "admin@example.com"
  }
}
```

### 2. List Available Exams
```bash
curl -X GET http://localhost:8000/api/v1/exams \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### 3. Start Exam
```bash
curl -X POST http://localhost:8000/api/v1/exams/1/start \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "device_id": "device_123"
  }'
```

### 4. Get Exam Questions
```bash
curl -X GET http://localhost:8000/api/v1/exams/1/questions \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### 5. Submit Answer
```bash
curl -X POST http://localhost:8000/api/v1/exams/1/answer \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "question_id": 1,
    "answer": "option_id_5"
  }'
```

### 6. Submit Exam
```bash
curl -X POST http://localhost:8000/api/v1/exams/1/submit \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### 7. Get Results
```bash
curl -X GET http://localhost:8000/api/v1/exams/1/results \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

## Admin Panel Quick Start

### 1. Access Admin Panel
```
http://localhost:8000/admin/exams
```

Requires admin authentication.

### 2. Create Exam
1. Click "New Exam"
2. Fill in exam details:
   - Exam name
   - Type (Test, Quiz, Assignment, Final Exam)
   - Jenjang (SD, SMP, SMA, Madrasah)
   - Duration (minutes)
   - Passing grade (0-100)
   - Start/End dates

3. Click "Save"

### 3. Create Question Group
1. Click exam → "Add Question Group"
2. Fill in:
   - Group name
   - Randomize questions: Yes/No
   - Randomize options: Yes/No

### 4. Add Questions
**Option A: Manual Creation**
1. Click question group → "Add Question"
2. Select question type
3. Enter content and options
4. Mark correct answer
5. Set points

**Option B: Import from File**
1. Click group → "Import Questions"
2. Upload file (Word/TXT/Blackboard)
3. System auto-creates questions and options

### 5. Configure Mobile Settings
1. Click exam → "Mobile Settings"
2. Enable password protection if needed:
   - Click "Generate Password" → Copy password
   - Or enter custom password
3. Configure anti-cheating:
   - ✅ Prevent screenshots
   - ✅ Prevent app switching
   - ✅ Prevent screen recording
   - ✅ Lock device orientation
4. Set idle timeout (seconds)
5. IP whitelist (optional):
   - Click "Add IP"
   - Enter IP address
6. Device whitelist (optional):
   - Click "Add Device"
   - Enter device ID and name

### 6. Publish Exam
1. Click exam → "Publish"
2. Exam now visible to students

### 7. View Results
1. Click exam → "Results"
2. See table:
   - Student name
   - Score
   - Percentage
   - Passed/Failed
   - Time taken

### 8. Monitor Activity
1. Click exam → "Activity Logs"
   - See all student activities
   - Timestamps, actions, IP addresses

2. Click exam → "Suspicious Activities"
   - See flagged cheating attempts
   - App switches, screenshots, etc.

---

## Mobile App Integration

### Login Flow
```
1. User opens mobile app
2. Enter username/email and password
3. App sends: device_id, device_name, os_type, os_version
4. Server returns: access_token + device_info
5. Token stored securely in device keychain
```

### Pre-Exam Validation
```
1. User selects exam
2. App calls: /api/v1/auth/validate-exam-password
3. If password required, show password dialog
4. Once validated, allow exam start
```

### Exam Taking
```
1. Click "Start Exam"
   → POST /api/v1/exams/{exam}/start
   
2. Load questions
   → GET /api/v1/exams/{exam}/questions
   
3. For each answer
   → POST /api/v1/exams/{exam}/answer
   
4. Keep sending heartbeats (every 30 seconds)
   → POST /api/v1/mobile/heartbeat
   
5. Final submit
   → POST /api/v1/exams/{exam}/submit
   
6. View results
   → GET /api/v1/exams/{exam}/results
```

### Anti-Cheating Events
```
App automatically logs:
- App switch (every time user leaves app)
  → POST /api/v1/mobile/track-app-switch
  
- Screenshot attempt
  → POST /api/v1/mobile/track-screenshot
  
- Suspicious activity
  → POST /api/v1/mobile/track-activity
  
- Session heartbeat (keeps session alive)
  → POST /api/v1/mobile/heartbeat
```

---

## Database Schema Quick Reference

### Key Tables

**exams**
```
id, exam_name, exam_type, description, jenjang
duration, passing_grade, is_published, user_id
start_date, end_date, start_time, end_time
```

**question_groups**
```
id, exam_id, name, description
randomize_questions, randomize_options, order_index
```

**questions**
```
id, question_group_id, user_id, content, question_type
points, difficulty_level, image_url, instructions
```

**question_options**
```
id, question_id, content, order_index, is_correct, image_url
```

**exam_participants**
```
id, exam_id, user_id, attempt_number
status, score, percentage, started_at, submitted_at
```

**exam_submissions**
```
id, exam_participant_id, question_id
user_answer, is_correct, points_earned
```

**mobile_app_settings**
```
id, exam_id, enable_password_protection, exam_password_hash
max_idle_time, prevent_screenshot, prevent_app_switching
lock_device_orientation, allowed_ips, allowed_devices
```

**cbt_activity_logs**
```
id, exam_participant_id, user_id, action
ip_address, user_agent, details, created_at
```

---

## File Import Format

### Word/Text Format
```
[1] Apa ibukota Indonesia?
a) Jakarta
b) Bandung
c) Surabaya
d) Medan
Jawaban: a

[2] Berapakah 2+2?
a) 3
b) 4
c) 5
d) 6
Jawaban: b
```

### File Requirements
- **Word**: .docx format (MS Office 2007+)
- **Text**: .txt format (UTF-8 encoding)
- **Blackboard**: QTI XML export (.xml)

### Character Limits
- Question text: 5000 characters
- Option text: 500 characters
- File size: Max 10 MB

---

## Common Tasks

### Change User Password
```bash
php artisan tinker
User::find(1)->update(['password' => Hash::make('newpassword')]);
```

### Reset Database
```bash
php artisan migrate:refresh
php artisan db:seed --class=PermissionSeeder
```

### Export Activity Logs
```bash
# Via admin panel: Click "Activity Logs" → "Export CSV"
# Or via database: SELECT * FROM cbt_activity_logs
```

### Backup Database
```bash
mysqldump -u root -p cbtv3 > backup_$(date +%Y%m%d).sql
```

### Restore Database
```bash
mysql -u root -p cbtv3 < backup_20260206.sql
```

---

## Troubleshooting

### 500 Error
1. Check logs: `storage/logs/laravel.log`
2. Enable debug: `.env` → `APP_DEBUG=true`
3. Clear cache: `php artisan cache:clear`

### Database Connection Error
1. Check .env database credentials
2. Verify MySQL is running: `mysql -u root -p`
3. Check database exists: `CREATE DATABASE cbtv3;`

### API Token Invalid
1. Token expired → Re-login to get new token
2. Wrong Authorization header format → Use "Authorization: Bearer TOKEN"
3. Token revoked → User logged out, re-login required

### Migration Errors
```bash
# If migration stuck, try fresh migration
php artisan migrate:fresh

# Or specific migration
php artisan migrate:refresh --path=database/migrations/2026_02_06_073331_create_cbt_base_tables.php
```

### File Upload Issues
1. Check storage permissions: `chmod -R 755 storage`
2. Check disk configuration in `config/filesystems.php`
3. Verify max upload size in `php.ini`

### Mobile App Connection Issues
1. Check API_BASE_URL in app config
2. Verify server is running: `php artisan serve`
3. Check CORS in `config/cors.php`
4. Review API logs for errors

---

## Performance Tips

### For Large Datasets
```php
// Use pagination
$questions = Question::paginate(50);

// Use select() to limit columns
$exams = Exam::select('id', 'exam_name')->get();

// Use eager loading (not lazy)
$exams = Exam::with('questionGroups.questions')->get();
```

### Caching
```php
// Cache exam settings
Cache::remember("exam.$examId.settings", 3600, function () {
    return Exam::find($examId)->mobileSettings;
});
```

### Database Optimization
```bash
# Check slow queries
SET GLOBAL slow_query_log = 'ON';
SET GLOBAL long_query_time = 2;

# View logs
tail -f /var/log/mysql/slow-query.log
```

---

## Security Best Practices

1. **Always use HTTPS** in production
2. **Update dependencies** regularly: `composer update`
3. **Enable CORS only for trusted domains**
4. **Use strong passwords** for admin accounts
5. **Enable 2FA** for admin users (if implemented)
6. **Rotate API tokens** periodically
7. **Monitor suspicious activities** regularly
8. **Keep backups** of important data
9. **Review activity logs** regularly
10. **Use environment variables** for secrets

---

## Next Steps

1. **Create first exam**: Go to admin panel
2. **Add questions**: Manually or import from file
3. **Configure mobile settings**: Set password & anti-cheating
4. **Publish exam**: Make visible to students
5. **Test with API**: Use Postman/cURL
6. **Test with mobile**: Install and test mobile app
7. **Monitor results**: View results and activity logs

---

## Resources

- **GitHub**: https://github.com/chandra35/cbtv3
- **Documentation**: [SETUP_GUIDE.md](./SETUP_GUIDE.md)
- **Checklist**: [DEVELOPMENT_CHECKLIST.md](./DEVELOPMENT_CHECKLIST.md)
- **API Docs**: See routes in `routes/api.php`
- **Laravel Docs**: https://laravel.com/docs
- **Sanctum Docs**: https://laravel.com/docs/sanctum
- **Spatie Permission**: https://spatie.be/docs/laravel-permission

---

**Version**: 1.0
**Last Updated**: 2026-02-06
**Status**: Production Ready (Phase 1)
