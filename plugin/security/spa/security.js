(async function ($) {
  $("#c9-security-tab-container").html(
    C9_TAB(
      [__("setting"), __("logs")],
      [
        $("<div>")
          .attr({
            class: "c9-padding-small",
          })
          .html([
            `<h2 class="c9-text-capitalize">${__(
              "2 step verification code"
            )}</h2>`,
            $("<div>").html([
              $("<div>")
                .attr({
                  class: "c9-margin-bottom-small",
                })
                .html(
                  $("<label>").html([
                    $("<input>")
                      .attr({
                        type: "checkbox",
                      })
                      .on("change", async function () {
                        var _response = await C9_API("security_2_step_update", {
                          security_2_step:
                            $(this).prop("checked") === true ? "1" : "0",
                        });

                        C9_NOTI(_response.response_text);
                      })
                      .prop(
                        "checked",
                        $("#c9-security_2_step-value").val() === "1"
                          ? true
                          : false
                      ),
                    __("Active 2 step sign in verification code"),
                  ])
                ),
              $("<div>")
                .attr({
                  class: "c9-margin-bottom-small",
                })
                .html([
                  $("<label>").html(__("Blocking time (second)")).attr({
                    class: "c9-margin-bottom-small",
                  }),
                  $("<div>").html(
                    $("<input>")
                      .attr({
                        type: "number",
                        class: "c9-margin-bottom-small",
                      })
                      .val($("#c9-security_2_step_blockingtime-value").val())
                      .on("change", async function () {
                        var _response = await C9_API(
                          "security_2_step_blockingtime_update",
                          {
                            timeout: $(this).val(),
                          }
                        );

                        C9_NOTI(_response.response_text);
                      })
                  ),
                ]),
              $("<button>")
                .attr({
                  class: "button c9-margin-bottom-small",
                })
                .on("click", async function () {
                  var _button_html = C9_DOM_LOADING($(this)[0]);

                  var _response = await C9_API("security_2_step_key_iv_reset");

                  C9_DOM_LOADING($(this)[0], _button_html);

                  if (_response.result === true) {
                    window.location.reload();
                  } else {
                    C9_NOTI(_response.response_text);
                  }
                })
                .html(
                  '<span class="dashicons dashicons-update c9-vertical-align-middle"></span> ' +
                    __("Force all user to sign out")
                ),
            ]),
            `<h2 class="c9-text-capitalize ">${__(
              "Anti brute force attack"
            )}</h2>`,
            $("<div>").html([
              $("<div>")
                .attr({
                  class: "c9-margin-bottom-small",
                })
                .html(
                  $("<label>").html([
                    $("<input>")
                      .attr({
                        type: "checkbox",
                      })
                      .on("change", async function () {
                        var _response = await C9_API(
                          "security_anti_brute_force_update",
                          {
                            security_anti_brute_force:
                              $(this).prop("checked") === true ? "1" : "0",
                          }
                        );

                        C9_NOTI(_response.response_text);
                      })
                      .prop(
                        "checked",
                        $(
                          "#c9-security_security_anti_brute_force-value"
                        ).val() === "1"
                          ? true
                          : false
                      ),
                    __("Active anti brute force attack"),
                  ])
                ),
            ]),
          ]),
        $("<div>").attr({
          id: "c9-brute-force-table-container",
        }),
      ],
      {
        tab_click_callback: function (tab_index) {
          if (tab_index === 1) {
            (async function () {
              var _response = await C9_API(
                "security_anti_brute_force_logs_get"
              );

              var _data = [];

              if (Array.isArray(_response.data) === true) {
                _response.data.forEach(function (data) {
                  var _attacker = data.option_name.split("[]");

                  if (!_attacker[1]) return;

                  _data.push({
                    username: _attacker[1],
                    ip: _attacker[2],
                    amount: data.option_value,
                    unblock: data.option_name,
                  });
                });
              }

              delete _response.data;

              $("#c9-brute-force-table-container").html("");

              new gridjs.Grid({
                columns: [
                  "username",
                  "ip",
                  "amount",
                  {
                    name: "unblock",
                    formatter: (data) => {
                      return gridjs.html(
                        `<button class="button action c9-anti-brute-force-unblock-button" data-id="${encodeURIComponent(
                          data
                        )}">Unblock</button>`
                      );
                    },
                  },
                ],
                data: _data,
                fixedHeader: true,
                autoWidth: true,
                sort: false,
                pagination: {
                  enabled: true,
                  limit: 30,
                  summary: true,
                  prevButton: false,
                  nextButton: false,
                },
              })
                .render(
                  document.getElementById("c9-brute-force-table-container")
                )
                .forceRender()
                .on("ready", function () {
                  $(".c9-anti-brute-force-unblock-button").on(
                    "click",
                    function () {
                      var _dom = $(this);

                      _anti_brute_force_blocked_remove(
                        _dom.attr("data-id"),
                        function () {
                          _dom.replaceWith(
                            '<span class="dashicons dashicons-yes"></span>'
                          );
                        }
                      );
                    }
                  );
                });
            })();
          }
        },
      }
    )
  );

  var _anti_brute_force_blocked_remove = async function (id, callback) {
    var _response = await C9_API("security_anti_brute_force_blocked_remove", {
      id: decodeURIComponent(id),
    });

    C9_NOTI(_response.response_text);

    callback();
  };
})(jQuery);
