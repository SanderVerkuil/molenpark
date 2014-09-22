$(document).ready(function() {
  $(window).hashchange(function(e) {
    LoadPage();
  })

  LoadPage();

  $("#search").submit(function(e) {
    console.log("submitted");
    LoadPage();
    e.preventDefault();
  });
  $(".song-search").change(LoadPage);
})

function LoadPage()
{
  var values, info = {};

  var array = location.hash.substr(1).split('&');

  for (var i = 0; i < array.length; i += 1)
  {
    var values = array[i].split('=');

    info[values[0]] = values[1];
  }

  url = base_url + "ajax/songs/100?page=" + (info.page != undefined ? info.page :  '');

  $.ajax({
    url: url,
    data: {
      'artist': $("#artiest").val(),
      'title': $("#title").val()
    },
    complete: function(jqxhr) {
      console.log(jqxhr);
      $('#overview').html(Render(jqxhr.responseJSON));
    },
    dataType: "json",
    cache: false
  })

}

function Render(data)
{
  var html;
  $.ajax({
    url: base_url + 'assets/templates/overview.mst',
    success: function(data)
    {
      html = data;
    },
    async: false,
    cache: false
  });

  html = RenderLoops(data, html);
  html = RenderData(data, html);
  html = Paginate(data, html);
  html = RemoveUnmatched(html);
  return html;

}

function RenderLoops(data, html)
{
  $.each(data, function(key, value) {
    var markupRegex = new RegExp("{{#" + key + "}}((.|\n)*?){{\\/" + key + "}}", "ig");
    var hiddenRegex = new RegExp("{{\\^" + key + "}}((.|\n)*?){{\\/" + key + "}}", "ig");

    var markupMatch = markupRegex.exec(html);
    var hiddenMatch = hiddenRegex.exec(html);
    var markupOutput = "";
    var hiddenOutput = "";

    if (markupMatch != null)
    {
      switch(typeof value)
      {
        case "boolean":
          if (value)
            markupOutput = markupMatch[1];
        break;
        case "function":
          if (value(data))
            markupOutput = markupMatch[1];
        break;
        default:
          var to = "";
          $.each(value, function (k, v)
          {
            switch(typeof v)
            {
              case "String":
                to += markupMatch[1].replace(/{{\.}}/ig, v);
              break;
              default:
                var t = RenderLoops(v, markupMatch[1]);
                to += RenderData(v, t);
            }
          });

          if (to == "")
            if (hiddenMatch != null)
              to = hiddenMatch[1];

          markupOutput += to;
        break;
      }
    }

    html = html.replace(markupRegex, markupOutput);
    html = html.replace(hiddenRegex, hiddenOutput);

  });
  return html;
}

function RenderData(data, html)
{
  $.each(data, function(key, value) {
    var patt = new RegExp("{{" + key + "}}", "g");
    html = html.replace(patt, value);
  })

  return html;
}

function RemoveUnmatched(html)
{
  return html.replace(/{{(.)*}}/g, "");
}

function Paginate(data, html)
{
  console.log(data);

  var currentPage = data.current_page;
  var last_page = data.last_page;
  var prevPage = currentPage-1;
  if (prevPage <= 1)
    prevPage = 1;
  var nextPage = currentPage+1;
  if (nextPage >= last_page)
    nextPage = last_page;

  var pageInfo = {
    prevDisabled: false,
    lastDisabled: false,
    pages: {},
    firstDisabled: false,
    nextDisabled: false,
    firstPage: 1,
    lastPage: last_page,
    prevPage: prevPage,
    nextPage: nextPage
  };

  if (currentPage <= 1)
  {
    pageInfo.prevDisabled = true;
    pageInfo.firstDisabled = true;
  }

  if (currentPage >= last_page)
  {
    pageInfo.nextDisabled = true;
    pageInfo.lastDisabled = true;
  }

  start = 1;
  end = last_page;

  for (var i = start; i <= end; i+=1)
  {
    thisPage = i == currentPage;
    pageInfo.pages[i] = {
      isActive: thisPage,
      active: function(a) {
        return (a.isActive);
      },
      number: i
    }
  }

  html = RenderLoops(pageInfo, html);
  html = RenderData(pageInfo, html);

  return html;
}
