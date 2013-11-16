
        <!-- search block -->
        <div class="search">
            <div class="search-input input">
                <i class='search-input-icon input-icon icon icon-search'></i>
                {{ Form::text('search', '', ['class' => 'search-input-field input-field input-has-icon']) }}
                {{ Form::label('search', 'Search', ['class' => 'search-input-lbl input-lbl input-has-icon lbl visible']) }}
            </div>
            <div class="search-results invisible">
                <div class="search-results-number">
                    <p class="search-results-number-text"></p>
                </div>
                <ul class="search-results-rsrc rsrc">
                </ul>
            </div>
        </div>