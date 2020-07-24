<footer class="footer">
    <div class="kat-container">
        <div class="links-footer">
            <div class="post">
                <img src="{{ asset('assets/imgs/local.png') }}" alt="">

                <p>{{ setting('site.address_footer_widget') }}</p>
            </div>
            <div class="post">
                <img src="{{ asset('assets/imgs/mes.png') }}" alt="">

                <div class="limks">
                    <a href="mailto:{{ setting('site.email_footer_widget') }}">{{ setting('site.email_footer_widget') }}</a>
                </div>
            </div>
            <div class="post">
                <img src="{{ asset('assets/imgs/tel.png') }}" alt="">

                <div class="limks">

                    <a href="tel:{{ setting('site.phone_footer_widget') }}">Tel: {{ setting('site.phone_footer_widget') }}</a>

                    <a href="tel:{{ setting('site.fax_footer_widget') }}">Fax: {{ setting('site.fax_footer_widget') }}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="kat-container">
        <div class="con-categori">
            <div class="categori-footer">
                <h3>Despre noi </h3>
            </div>
            <div class="categori-footer">
                <h3>Noutăți</h3>
                <div class="categori-footer" style="padding-top: 20px;width: 100%">
                    <h3 style="border-bottom: 1px solid #555555; width: 238px; margin-bottom: 5px; padding-bottom: 10px;">
                        Studiem</h3>
                </div>
            </div>
            <div class="categori-footer">
                <h3> Articole</h3>
            </div>
            <div class="categori-footer">
                <h3> Legislația</h3>
            </div>
            <div class="categori-footer">
                <h3> Informații utile</h3>
            </div>


            <div class="categori-footer">
                <a href="{{ setting('site.twitter_widget') }}" class="icon-div"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                <a href="{{ setting('site.facebook_widget') }}" class="icon-div"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                <a href="{{ setting('site.linkedin_widget') }}" class="icon-div"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                <a href="{{ setting('site.google_widget') }}" class="icon-div"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
                <a href="{{ setting('site.rss_widget') }}" class="icon-div"><i class="fa fa-rss" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>
    <div class="kat-container">
        <div class="loc">
        </div>
    </div>
</footer>
