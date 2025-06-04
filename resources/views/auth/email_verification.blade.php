<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email</title>
    <style>
        /* Tailwind-inspired utility classes */
        .bg-gradient-primary {
            background: linear-gradient(135deg, #3B82F6 0%, #8B5CF6 100%);
        }

        .bg-gradient-success {
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
        }

        .bg-gradient-warning {
            background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
        }

        .bg-white {
            background-color: #ffffff;
        }

        .bg-gray-50 {
            background-color: #f9fafb;
        }

        .bg-gray-100 {
            background-color: #f3f4f6;
        }

        .bg-blue-50 {
            background-color: #eff6ff;
        }

        .bg-yellow-50 {
            background-color: #fffbeb;
        }

        .text-white {
            color: #ffffff;
        }

        .text-gray-600 {
            color: #4b5563;
        }

        .text-gray-700 {
            color: #374151;
        }

        .text-gray-800 {
            color: #1f2937;
        }

        .text-gray-900 {
            color: #111827;
        }

        .text-blue-600 {
            color: #2563eb;
        }

        .text-yellow-800 {
            color: #92400e;
        }

        .rounded-none {
            border-radius: 0;
        }

        .rounded-lg {
            border-radius: 0.5rem;
        }

        .rounded-xl {
            border-radius: 0.75rem;
        }

        .rounded-2xl {
            border-radius: 1rem;
        }

        .rounded-full {
            border-radius: 9999px;
        }

        .shadow-sm {
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .shadow-xl {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .p-4 {
            padding: 1rem;
        }

        .p-6 {
            padding: 1.5rem;
        }

        .p-8 {
            padding: 2rem;
        }

        .px-4 {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        .px-8 {
            padding-left: 2rem;
            padding-right: 2rem;
        }

        .py-3 {
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }

        .py-4 {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        .py-6 {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }

        .m-0 {
            margin: 0;
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto;
        }

        .mb-2 {
            margin-bottom: 0.5rem;
        }

        .mb-4 {
            margin-bottom: 1rem;
        }

        .mb-6 {
            margin-bottom: 1.5rem;
        }

        .mb-8 {
            margin-bottom: 2rem;
        }

        .mt-6 {
            margin-top: 1.5rem;
        }

        .mt-8 {
            margin-top: 2rem;
        }

        .text-sm {
            font-size: 0.875rem;
            line-height: 1.25rem;
        }

        .text-base {
            font-size: 1rem;
            line-height: 1.5rem;
        }

        .text-lg {
            font-size: 1.125rem;
            line-height: 1.75rem;
        }

        .text-xl {
            font-size: 1.25rem;
            line-height: 1.75rem;
        }

        .text-2xl {
            font-size: 1.5rem;
            line-height: 2rem;
        }

        .text-3xl {
            font-size: 1.875rem;
            line-height: 2.25rem;
        }

        .font-medium {
            font-weight: 500;
        }

        .font-semibold {
            font-weight: 600;
        }

        .font-bold {
            font-weight: 700;
        }

        .font-black {
            font-weight: 900;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .border {
            border-width: 1px;
        }

        .border-gray-200 {
            border-color: #e5e7eb;
        }

        .border-yellow-200 {
            border-color: #fde68a;
        }

        .border-l-4 {
            border-left-width: 4px;
        }

        .border-l-blue-500 {
            border-left-color: #3b82f6;
        }

        .border-l-yellow-500 {
            border-left-color: #eab308;
        }

        .w-full {
            width: 100%;
        }

        .max-w-2xl {
            max-width: 42rem;
        }

        .min-h-screen {
            min-height: 100vh;
        }

        .flex {
            display: flex;
        }

        .inline-flex {
            display: inline-flex;
        }

        .items-center {
            align-items: center;
        }

        .justify-center {
            justify-content: center;
        }

        .space-y-4>*+* {
            margin-top: 1rem;
        }

        .space-y-6>*+* {
            margin-top: 1.5rem;
        }

        /* Custom email-specific styles */
        body {
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .email-container {
            max-width: 42rem;
            margin: 2rem auto;
            padding: 1rem;
        }

        .email-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 1rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 1rem 2rem;
            background: linear-gradient(135deg, #3B82F6 0%, #8B5CF6 100%);
            color: white;
            text-decoration: none;
            border-radius: 9999px;
            font-weight: 700;
            font-size: 1rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15);
        }

        .icon-circle {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 4rem;
            height: 4rem;
            background: rgba(59, 130, 246, 0.1);
            border-radius: 50%;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .link-box {
            word-break: break-all;
            background: #f3f4f6;
            padding: 1rem;
            border-radius: 0.5rem;
            border: 2px dashed #d1d5db;
            font-family: ui-monospace, SFMono-Regular, "SF Mono", Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            font-size: 0.875rem;
            color: #374151;
        }

        /* Responsive */
        @media (max-width: 640px) {
            .email-container {
                margin: 1rem;
                padding: 0.5rem;
            }

            .text-3xl {
                font-size: 1.5rem;
                line-height: 2rem;
            }

            .text-2xl {
                font-size: 1.25rem;
                line-height: 1.75rem;
            }

            .p-8 {
                padding: 1.5rem;
            }

            .px-8 {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-card">
            <!-- Header -->
            <div class="bg-gradient-primary p-8 text-center">
                <div class="icon-circle mx-auto bg-white text-blue-600">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M1.5 8.67v8.58a3 3 0 003 3h15a3 3 0 003-3V8.67l-8.928 5.493a3 3 0 01-3.144 0L1.5 8.67z" />
                        <path d="M22.5 6.908V6.75a3 3 0 00-3-3h-15a3 3 0 00-3 3v.158l9.714 5.978a1.5 1.5 0 001.572 0L22.5 6.908z" />
                    </svg>
                </div>
                <h1 class="text-3xl font-black text-white m-0 mb-2">SPK COPRAS</h1>
                <p class="text-white m-0">Sistem Pendukung Keputusan Metode COPRAS</p>
            </div>

            <!-- Content -->
            <div class="p-8 space-y-6">
                <div class="text-center">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Welcome, {{ $user->nama_lengkap }}! 🎉</h2>
                    <p class="text-gray-600 text-base">
                        Thank you for registering with our Decision Support System! To complete your registration and start using your account, please verify your email address.
                    </p>
                </div>

                <div class="text-center">
                    <a href="{{ $verificationUrl }}" class="btn-primary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="margin-right: 0.5rem;">
                            <path d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Verify My Email Address
                    </a>
                </div>

                <div class="bg-gray-50 p-6 rounded-lg">
                    <p class="text-sm text-gray-700 mb-4 m-0"><strong>Alternative method:</strong></p>
                    <p class="text-sm text-gray-600 mb-4 m-0">If the button above doesn't work, copy and paste this link into your browser:</p>
                    <div class="link-box">{{ $verificationUrl }}</div>
                </div>

                <div class="bg-yellow-50 border border-yellow-200 border-l-4 border-l-yellow-500 p-4 rounded-lg">
                    <div class="flex">
                        <div style="margin-right: 0.75rem; color: #eab308;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-yellow-800 m-0 mb-2">Important Notice</p>
                            <p class="text-sm text-yellow-800 m-0">This verification link will expire in <strong>24 hours</strong>. If you don't verify your account within this time, you'll need to request a new verification email.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-50 border border-blue-200 border-l-4 border-l-blue-500 p-4 rounded-lg">
                    <div class="flex">
                        <div style="margin-right: 0.75rem; color: #3b82f6;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-blue-600 m-0 mb-2">Security Note</p>
                            <p class="text-sm text-gray-700 m-0">If you didn't create an account with us, please ignore this email. No action is required from you.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 p-6 text-center border-t border-gray-200">
                <p class="text-base font-semibold text-gray-900 m-0 mb-2">Best regards,</p>
                <p class="text-base font-medium text-gray-700 m-0 mb-4">The SPK COPRAS Team</p>
                <p class="text-sm text-gray-600 m-0">This is an automated email. Please do not reply to this message.</p>
            </div>
        </div>
    </div>
</body>

</html>