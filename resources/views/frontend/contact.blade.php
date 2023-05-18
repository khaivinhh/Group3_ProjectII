@extends('frontend/layout/layout')

@section('contents')

<section class="title">
    <h1>Contact</h1>
    <a href="">Home</a>
    <span>/</span>
    <a href="">Contact</a>
</section>

<section class="contact">
    <div class="information_company">
        <div>
            <p class="title_contact1">Contact Us</p>
            <div>
                <p><i class="fa-solid fa-house"></i> Address</p>
                <p>391A Nam Ky Khoi Nghia - Ward 7 - District 3 - Ho Chi Minh</p>
            </div>
            <div>
                <p><i class="fa-solid fa-phone"></i> Phone</p>
                <p>Mobide (84) 347809470</p>
            </div>
            <div>
                <p><i class="fa-solid fa-envelope"></i> Email</p>
                <p>ishoppapple@gmail.com</p>
            </div>
        </div>

    </div>
    <div class="form_send">
        <p class="title_contact2">Tell Us Your Message</p>
        <form class="form_contact">
            <div>
                <label for="name">Your Name</label><br>
                <input type="text" id="name_contact" name="name" required>
            </div>
            <div>
                <label for="email">Your Email</label><br>
                <input type="text" id="email_contact" name="email" required>
            </div>
            <div>
                <label for="subject">Subject</label><br>
                <input type="text" id="subject_contact" name="subject">
            </div>
            <div>
                <label for="message">Your Message</label><br>
                <textarea name="message" id="message_contact" cols="30" rows="10"></textarea>
            </div>
            <button type="submit">Send</button>
        </form>
    </div>
</section>

<iframe class="iframe_contact" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.276678633434!2d106.6811446748572!3d10.790108489359504!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317528d33549cc91%3A0xb24c365a1b8651ac!2zMzkxIMSQLiBOYW0gS-G7syBLaOG7n2kgTmdoxKlhLCBQaMaw4budbmcgOCwgUXXhuq1uIDMsIFRow6BuaCBwaOG7kSBI4buTIENow60gTWluaCwgVmlldG5hbQ!5e0!3m2!1sen!2s!4v1683343773757!5m2!1sen!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
@endsection

@section('myjs')
<script>
    $('.form_contact').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: "{{route('send_mail_contact')}}",
            data: {
                name: $('#name_contact').val(),
                email: $('#email_contact').val(),
                subject: $('#subject_contact').val(),
                message: $('#message_contact').val(),
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {
                $('.text-2').text('Successfully !');
                notification_complete();
            }
        });
    })
</script>
@endsection