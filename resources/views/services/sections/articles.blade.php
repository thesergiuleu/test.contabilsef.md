<section id="articles" class="articles">
    <h2 class="section-title">Ultimele titluri ale Revistei online "Contabilsef.md"</h2>
    <h3 class="section-subtitle">Vedeți articole recent publicate</h3>
    <div class="content">
        @foreach($posts as $item)
            <div class="article-item">
                <div class="icon">
                    <img class="image" src="{{ $item->thumbnail_url }}" alt="article-image">
                </div>
                <div>
                    <h5 class="title">{{ $item->title }}</h5>
                    <div class="author">Some undefined author</div>
                    <p class="text"> {!! $item->getShort(200) !!}</p>
                </div>
            </div>
        @endforeach
    </div>
    <div class="action">
        <a href="#subscription" class="section-button">Primiți acces la articole</a>
    </div>
</section>
