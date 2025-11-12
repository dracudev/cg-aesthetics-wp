import type { APIRoute } from 'astro';
import { config } from 'dotenv';

// Load environment variables from .env
config();

export const prerender = false;

export const POST: APIRoute = async ({ request }) => {
  try {
    // Parse the form data
    const text = await request.text();
    const data = JSON.parse(text);

    const { firstName, lastName, email, phone, subject, message } = data;

    // Validate required fields
    if (!firstName || !lastName || !email || !subject || !message) {
      return new Response(
        JSON.stringify({ error: 'Missing required fields' }),
        { status: 400, headers: { 'Content-Type': 'application/json' } }
      );
    }

    // Business owner email
    const businessEmail = 'carmeng.beautych@gmail.com';

    // Get API key from environment
    const resendApiKey = process.env.RESEND_API_KEY;

    console.log('Checking for RESEND_API_KEY...');
    console.log('API Key exists:', !!resendApiKey);

    if (!resendApiKey) {
      console.warn('RESEND_API_KEY not configured');
      return new Response(
        JSON.stringify({
          error: 'Email service not configured',
          message: 'Please add RESEND_API_KEY to .env file',
        }),
        { status: 500, headers: { 'Content-Type': 'application/json' } }
      );
    }

    // Send email via Resend
    const response = await fetch('https://api.resend.com/emails', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        Authorization: `Bearer ${resendApiKey}`,
      },
      body: JSON.stringify({
        from: 'onboarding@resend.dev',
        to: businessEmail,
        reply_to: email,
        subject: `[Carmen Gómez Contact] ${subject}`,
        html: `
          <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;">
            <h2 style="color: #c99a6e; border-bottom: 2px solid #c99a6e; padding-bottom: 10px;">
              Nouvelle Demande de Contact - Carmen Gómez
            </h2>
            
            <div style="background-color: #f9f9f9; padding: 15px; margin: 20px 0; border-left: 4px solid #c99a6e;">
              <p><strong>Prénom:</strong> ${firstName}</p>
              <p><strong>Nom:</strong> ${lastName}</p>
              <p><strong>Email:</strong> <a href="mailto:${email}">${email}</a></p>
              <p><strong>Téléphone:</strong> ${phone || 'Non fourni'}</p>
            </div>

            <div style="background-color: #f9f9f9; padding: 15px; margin: 20px 0; border-left: 4px solid #c99a6e;">
              <p><strong>Sujet:</strong></p>
              <p style="margin: 10px 0;">${subject}</p>
            </div>

            <div style="background-color: #f9f9f9; padding: 15px; margin: 20px 0; border-left: 4px solid #c99a6e;">
              <p><strong>Message:</strong></p>
              <p style="margin: 10px 0; white-space: pre-wrap;">${message}</p>
            </div>

            <div style="color: #999; font-size: 12px; margin-top: 30px; padding-top: 15px; border-top: 1px solid #ddd;">
              <p>Date: ${new Date().toLocaleString('fr-CH')}</p>
            </div>
          </div>
        `,
      }),
    });

    const responseData = await response.json().catch(() => ({}));
    console.log('Resend response:', response.status, responseData);

    if (!response.ok) {
      console.error('Resend API error:', responseData);
      return new Response(
        JSON.stringify({
          error: 'Failed to send email',
          details: responseData,
        }),
        { status: 500, headers: { 'Content-Type': 'application/json' } }
      );
    }

    console.log('✅ Email sent successfully!');
    return new Response(
      JSON.stringify({
        success: true,
        message: 'Email sent successfully',
      }),
      { status: 200, headers: { 'Content-Type': 'application/json' } }
    );
  } catch (error) {
    const errorMessage = error instanceof Error ? error.message : String(error);
    console.error('❌ Error:', errorMessage);
    return new Response(
      JSON.stringify({
        error: 'Server error',
        details: errorMessage,
      }),
      { status: 500, headers: { 'Content-Type': 'application/json' } }
    );
  }
};
