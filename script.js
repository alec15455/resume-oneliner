$(document).ready(function() {
    const stripe = Stripe(stripePublicKey);  // This will be defined in your PHP

    $('#checkout-button').click(function() {
        $.post('index.php', {
            action: 'create_checkout'
        }, function(data) {
            stripe.redirectToCheckout({
                sessionId: data.id
            });
        }, 'json');
    });

    $('#submit-line').click(function() {
        const currentLine = $('#current-line').val();
        if (!currentLine) {
            alert('Please enter your current resume line');
            return;
        }

        $.post('index.php', {
            action: 'submit_line',
            current_line: currentLine,
            session_id: sessionId  // This will be defined in your PHP
        }, function(data) {
            if (data.status === 'success') {
                $('.form-group').html('<div class="success-message">Thank you! Your improved resume line will be delivered to your email within 24 hours.</div>');
                $('#submit-line').hide();
            }
        }, 'json');
    });
});
