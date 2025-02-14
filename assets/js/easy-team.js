jQuery(document).ready(function($) {
    $('.view-details-btn').on('click', function() {
        let name = $(this).data('name');
        let job = $(this).data('job');
        let email = $(this).data('email');
        let phone = $(this).data('phone');
        let vcard = $(this).data('vcard');
        let content = $(this).data('content');
        let image = $(this).data('img'); // Get the team member's image

        $('#modal-content-area').html(`
            <div class="modal-grid">
                <div class="modal-column">
                    <img src="${image}" alt="${name}" style="max-width: 100%; width: 100%; border-radius: 8px;">
                </div>
                <div class="modal-column d-middle">
                    <h3 style="font-size:22px;">${name}</h3>
                    <p><strong>Job Title:</strong> ${job}</p>
                    <p><strong>Email:</strong> <a href="mailto:${email}">${email}</a></p>
                    <p><strong>Phone:</strong> <a href="tel:${phone}">${phone}</a></p>
                    <p><a class="downloadbtn" href="${vcard}" download>Download vCard</a></p>
                </div>
                <div class="modal-column d-middle" style="font-size:13px;">
        <p>${content}</p>
                </div>
            </div>
        `);

        $('#team-popup').fadeIn();
    });

    $('.close-modal').on('click', function() {
        $('#team-popup').fadeOut();
    });

    $(document).on('click', function(e) {
        if ($(e.target).closest('.team-modal-content').length === 0 && $(e.target).closest('.view-details-btn').length === 0) {
            $('#team-popup').fadeOut();
        }
    });
});
