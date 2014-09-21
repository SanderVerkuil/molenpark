$(document).ready(function() {
  var values, info = {};

  var array = location.hash.substr(1).split('&');

  for (var i = 0; i < array.length; i += 1)
  {
    var values = array[i].split('=');

    info[values[0]] = values[1];
  }

  url = base_url + "ajax/songs?page=" + (info.page != undefined ? info.page :  '');

  LoadPage();
})

function LoadPage()
{
  $.ajax({
    url: url,
    complete: function(jqxhr) {
      $('#overview').html(Render(jqxhr.responseJSON));
    },
    dataType: "json"
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
                console.log(v);
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
