<!DOCTYPE html>
<html>
<body style="font-family: sans-serif; background-color: #F8FAFC; padding: 40px;">
    <div style="max-width: 600px; margin: 0 auto; bg-color: #ffffff; padding: 40px; border-radius: 30px; border: 1px solid #e2e8f0;">
        <h1 style="color: #0f172a; font-size: 24px; font-weight: 900; letter-spacing: -1px;">
            co<span style="color: #10b981;">loc.</span>
        </h1>
        <p style="color: #475569; font-size: 16px; line-height: 1.6;">
            You've been invited to join <strong>{{ $invitation->colocation->name }}</strong> to start tracking shared expenses.
        </p>
        <div style="margin-top: 32px;">
            <a href="{{ route('invitations.accept', $invitation->token) }}" 
               style="background-color: #0f172a; color: #ffffff; padding: 16px 32px; border-radius: 16px; text-decoration: none; font-weight: bold; font-size: 14px; display: inline-block;">
                Accept Invitation
            </a>
        </div>
        <p style="margin-top: 32px; color: #94a3b8; font-size: 12px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px;">
            Link expires in 48 hours.
        </p>
    </div>
</body>
</html>