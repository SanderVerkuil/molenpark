var Renderer = function()
{
  var exports = {};

  var options = {
    renderContext: $("body"),
    loadingContext: $("body"),
    templateUrl: undefined,
    data: undefined,
    complete: function(output, context) {},
    append: true,
    removeUnmatched: false
  }

  function Render(opts)
  {
    $.extend(options, opts);

    if (options.templateUrl == undefined)
      throw "Template can't be undefined";
    if (options.data == undefined)
      throw "Data can't be undefined";

    var html;
    $.ajax({
      url: options.templateUrl,
      success: function(data)
      {
        html = data;
      },
      async: false,
      cache: false
    });

    var data = options.data;

    html = RenderLoops(data, html);
    html = RenderData(data, html);
    html = Paginate(data, html);

    if (options.removeUnmatched)
      html = RemoveUnmatched(html);

    options.renderingContext.html(html);

    options.complete($(html), options.renderingContext);


  }
  exports.render = Render;

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
  return exports;
}
