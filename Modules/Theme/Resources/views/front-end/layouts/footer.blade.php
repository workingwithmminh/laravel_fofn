<footer>
    <div class="container">
        <p class="footer__social">
            <a target="_blank" rel="nofollow" href="{!! $settings['follow_facebook'] !!}"><i class="fab fa-facebook px-2"></i></a>
            <a target="_blank" rel="nofollow" href=""><i class="fab fa-twitter px-2"></i></a>
            <a target="_blank" rel="nofollow" href="{!! $settings['follow_instagram'] !!}"><i class="fab fa-instagram px-2"></i></a>
            <a target="_blank" rel="nofollow" href="{!! $settings['follow_youtube'] !!}"><i class="fab fa-youtube"></i></a>
        </p>
        <h4 class="footer__social__title">Liên hệ quảng cáo</h4>
        <div class="footer__social__content">
            <p>Điện thoại:<strong> {{ $settings['company_phone'] }}</strong><br>
                Email: <strong>{{ $settings['company_email'] }}</strong></p>
            <p>Đ/c: {{ $settings['company_address'] }}</p>
        </div>
        <hr>
        <div class="footer__copyright">Copyright © 2019 Kiến thức kinh tế. All rights reserved</div>
    </div>
</footer>