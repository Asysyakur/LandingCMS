# ComPro CMS API - Postman Collection

This directory contains a comprehensive Postman collection for testing the ComPro CMS API endpoints.

## 📁 Files

- `ComPro-CMS-API.postman_collection.json` - Complete Postman collection with all API endpoints
- `README.md` - This documentation file

## 🚀 Getting Started

### 1. Import Collection to Postman

1. Open Postman
2. Click **Import** in the top left
3. Select **File** tab
4. Choose `ComPro-CMS-API.postman_collection.json`
5. Click **Import**

### 2. Configure Environment Variables

The collection uses these variables:
- `base_url` - Your API base URL (default: `http://127.0.0.1:8000`)
- `access_token` - JWT token (auto-set after login)
- `page_id` - Page ID for testing (auto-set after creating page)
- `component_id` - Component ID for testing (auto-set after adding component)
- `version_id` - Version ID for testing (auto-set after getting versions)

### 3. Start Testing

Follow this order for testing:

1. **Authentication** - Register/Login first to get token
2. **Pages Management** - Create and manage pages
3. **Components** - Add components to pages
4. **Version Management** - Test versioning features
5. **Analytics** - Test analytics endpoints
6. **Preview** - Test preview functionality

## 📋 API Endpoints Covered

### 🔐 Authentication
- `POST /api/register` - Register new user
- `POST /api/login` - User login
- `GET /api/profile` - Get user profile
- `PUT /api/profile` - Update user profile
- `POST /api/change-password` - Change password
- `POST /api/logout` - User logout

### 📄 Pages Management
- `GET /api/cms/pages` - List all pages
- `POST /api/cms/pages` - Create new page
- `GET /api/cms/pages/{id}` - Get page details
- `PUT /api/cms/pages/{id}` - Update page
- `DELETE /api/cms/pages/{id}` - Delete page

### 🧩 Components
- `GET /api/cms/components` - List all components
- `POST /api/cms/pages/{pageId}/components` - Add component to page
- `PUT /api/cms/pages/{pageId}/components/{componentId}` - Update page component
- `DELETE /api/cms/pages/{pageId}/components/{componentId}` - Remove component

### 📝 Version Management
- `GET /api/cms/pages/{pageId}/versions` - Get page versions
- `POST /api/cms/pages/{pageId}/versions/{versionId}/restore` - Restore version

### 📊 Analytics
- `GET /api/analytics/dashboard` - Get dashboard stats
- `GET /api/analytics/pages/{pageId}` - Get page analytics
- `POST /api/analytics/track/{pageSlug}` - Track visitor (public)

### 👁️ Preview
- `GET /api/preview/pages/{pageId}` - Preview page
- `GET /api/preview/pages/{pageId}/responsive` - Get responsive preview
- `GET /api/preview/components/{componentSlug}/schema` - Get component schema
- `POST /api/preview/components/{componentSlug}/preview` - Get component preview
- `GET /api/preview/public/{pageSlug}` - Public page preview

## 🛠️ Features

### Auto Variables
- **Token Management**: Automatically saves JWT token after successful login/register
- **Page ID**: Auto-saves page ID after creating a page
- **Component ID**: Auto-saves component ID after adding component
- **Version ID**: Auto-saves version ID for restore operations

### Test Scripts
- **Status Code Validation**: Checks for successful HTTP status codes (200, 201, 204)
- **Response Time**: Ensures API responds within 3 seconds
- **Token Handling**: Automatically extracts and stores authentication tokens

### Sample Data
The collection includes realistic sample data for:
- UMKM business profiles
- Component content (hero sections, etc.)
- Analytics tracking data
- User registration/login data

## 📝 Usage Tips

1. **Run in Order**: Execute requests in the suggested order for proper variable setup
2. **Check Variables**: After each successful operation, verify that variables are set correctly
3. **Update Base URL**: Change `base_url` if your API runs on a different port or domain
4. **Test Scenarios**: Try different data combinations to test validation and error handling

## 🐛 Troubleshooting

### Common Issues

1. **401 Unauthorized**: 
   - Make sure you've logged in first
   - Check if `access_token` variable is set

2. **404 Not Found**:
   - Verify `page_id` or `component_id` variables are set
   - Check if the resource exists

3. **422 Validation Error**:
   - Review the request body format
   - Ensure all required fields are included

4. **Connection Error**:
   - Check if your Laravel server is running
   - Verify `base_url` is correct

### Debug Mode
Enable Postman console to see:
- Variable assignments
- Request/response details
- Error messages

## 🔄 Workflow Example

```
1. POST /api/register → Creates user, saves token
2. POST /api/login → Logs in, refreshes token
3. POST /api/cms/pages → Creates page, saves page_id
4. GET /api/cms/components → Gets available components
5. POST /api/cms/pages/{pageId}/components → Adds component, saves component_id
6. GET /api/preview/pages/{pageId} → Preview the page
7. GET /api/cms/pages/{pageId}/versions → Get versions, saves version_id
8. POST /api/cms/pages/{pageId}/versions/{versionId}/restore → Restore version
```

## 📞 Support

For issues with the API itself, check:
- Laravel logs: `storage/logs/laravel.log`
- Database migrations
- Route definitions in `routes/api.php`

For Postman collection issues:
- Verify JSON syntax
- Check variable names
- Ensure proper import procedure
