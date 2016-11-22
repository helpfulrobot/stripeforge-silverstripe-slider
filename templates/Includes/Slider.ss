<% cached $ActiveSlides.Count, $ActiveSlides.max(LastEdited) %>
  <% if $ActiveSlides %>
    <section class="page__slider">
      <div class="slider__slides">
        <% loop $ActiveSlides %>
          <div class="slides__slide">
            <% if $ShowTitle || $Content || $Link %>
              <div class="slide__caption">
                <% if $ShowTitle %>
                  <h3>$Title</h3>
                <% end_if %>
                <% if $Content %>
                  <p>$Content</p>
                <% end_if %>
                <% if $Link %>
                  <a class="btn white" href="$Link.Url" <% if $ImageLink.Linkmode == URL %>target="_blank"<% end_if %> title="$Link.Page.Title">$Link.Title</a>
                <% end_if %>
              </div>
            <% end_if %>
            $Image.FocusFill($Top.SlideWidth,$Top.SlideHeight)
          </div>
        <% end_loop %>
      </div>
    </section>
  <% end_if %>
<% end_cached %>