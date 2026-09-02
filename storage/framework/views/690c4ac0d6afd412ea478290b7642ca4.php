<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EkskulSMK</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
        body { background-color: #f8fafc; color: #0f172a; min-height: 100vh; }
        .split-container { display: flex; min-height: 100vh; width: 100%; }
        
        /* Panel Dark Navy (Sisi Gelap) */
        .panel-navy { flex: 1; background-color: #0b1329; color: #ffffff; padding: 48px; display: flex; flex-direction: column; justify-content: space-between; }
        .brand-logo { display: flex; align-items: center; gap: 10px; font-weight: 700; font-size: 20px; }
        .brand-icon { background: #2563eb; width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 16px; }
        .hero-content { max-width: 480px; margin: auto 0; }
        .hero-title { font-size: 36px; font-weight: 800; line-height: 1.2; margin-bottom: 16px; }
        .hero-desc { color: #94a3b8; font-size: 15px; line-height: 1.6; }
        
        /* Widget Kartu di Panel Navy */
        .widget-card { background: rgba(30, 41, 59, 0.7); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 12px; padding: 20px; margin-top: 32px; }
        .profile-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; }
        .user-info { display: flex; align-items: center; gap: 12px; }
        .avatar { width: 40px; height: 40px; border-radius: 50%; background: #3b82f6; }
        .badge-active { background: #059669; color: #ecfdf5; font-size: 11px; padding: 2px 8px; border-radius: 12px; font-weight: 600; }
        .progress-item { margin-bottom: 10px; }
        .progress-label { display: flex; justify-content: space-between; font-size: 12px; color: #94a3b8; margin-bottom: 4px; }
        .progress-bar { background: rgba(255, 255, 255, 0.1); height: 6px; border-radius: 3px; overflow: hidden; }
        .progress-fill { background: #2563eb; height: 100%; border-radius: 3px; }

        /* Panel Form White (Sisi Terang) */
        .panel-white { flex: 1; background-color: #ffffff; padding: 48px; display: flex; align-items: center; justify-content: center; }
        .form-box { width: 100%; max-width: 420px; }
        .form-title { font-size: 28px; font-weight: 800; color: #0f172a; margin-bottom: 6px; }
        .form-subtitle { color: #64748b; font-size: 14px; margin-bottom: 24px; }
        
        /* Tab Peran / Role */
        .role-tabs { display: flex; background: #f1f5f9; padding: 4px; border-radius: 8px; margin-bottom: 20px; }
        .role-btn { flex: 1; text-align: center; padding: 8px; font-size: 13px; font-weight: 600; color: #64748b; border: none; background: transparent; cursor: pointer; border-radius: 6px; }
        .role-btn.active { background: #2563eb; color: #ffffff; }

        /* Form Inputs & Buttons */
        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 6px; }
        .form-input { width: 100%; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px; outline: none; transition: 0.2s; }
        .form-input:focus { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); }
        .form-flex { display: flex; justify-content: space-between; align-items: center; font-size: 13px; margin-bottom: 20px; }
        .btn-blue { width: 100%; background: #2563eb; color: #ffffff; padding: 12px; border: none; border-radius: 8px; font-weight: 700; font-size: 14px; cursor: pointer; }
        .btn-blue:hover { background: #1d4ed8; }
        
        /* SSO Buttons */
        .divider { display: flex; align-items: center; text-align: center; color: #94a3b8; font-size: 12px; margin: 20px 0; }
        .divider::before, .divider::after { content: ''; flex: 1; border-bottom: 1px solid #e2e8f0; }
        .divider span { padding: 0 10px; }
        .sso-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .sso-btn { border: 1px solid #e2e8f0; background: #ffffff; padding: 10px; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; }
        
        .footer-text { text-align: center; font-size: 13px; color: #64748b; margin-top: 24px; }
        .footer-text a { color: #2563eb; text-decoration: none; font-weight: 600; }

        @media (max-width: 868px) {
            .split-container { flex-direction: column; }
            .panel-navy { display: none; }
        }
    </style>
</head>
<body>
    <?php echo $__env->yieldContent('content'); ?>
</body>
</html><?php /**PATH C:\laragon\www\EskulManager\resources\views/layouts/app.blade.php ENDPATH**/ ?>