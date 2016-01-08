<span class="star-rating">
    @for ($i = 0; $i < round($stars); $i++)
        <span class="mdi mdi-star"></span>
    @endfor
    @for ($i = 0; $i < 5 - round($stars); $i++)
        <span class="mdi mdi-star-outline"></span>
    @endfor
</span>