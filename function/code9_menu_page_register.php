<?php

function code9_menu_page()
{
  add_menu_page(
    'Code9',
    'Code9',
    'delete_others_posts',
    'code9',
    'code9_dashboard',
    'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxOS4wLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiDQoJIHZpZXdCb3g9Ii0zNTkgMzc5LjMgMzA0LjQgMjY3LjciIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgLTM1OSAzNzkuMyAzMDQuNCAyNjcuNzsiIHhtbDpzcGFjZT0icHJlc2VydmUiPg0KPHN0eWxlIHR5cGU9InRleHQvY3NzIj4NCgkuc3Qwe2ZpbGw6I0ZGRkZGRjt9DQo8L3N0eWxlPg0KPGcgaWQ9IlhNTElEXzFfIj4NCgk8ZyBpZD0iWE1MSURfMl8iPg0KCQk8cGF0aCBpZD0iWE1MSURfM18iIGNsYXNzPSJzdDAiIGQ9Ik0tMjIxLjcsNTg1LjdWNjQ3TC0zNTksNTM4Ljl2LTUxLjhsMTM3LjMtMTA3Ljh2NjEuM2wtOTUsNzIuNEwtMjIxLjcsNTg1Ljd6Ii8+DQoJCTxwYXRoIGlkPSJYTUxJRF81XyIgY2xhc3M9InN0MCIgZD0iTS0xOTEuOSw1MTMuMlYzNzkuM2wzNy43LDI5LjZsLTEuOCw4LjZsLTI0LjcsMzQuMWwyMi4yLTEuNWwtMjQuNyw1NS40bDQyLjYtNjRMLTE2Myw0NDINCgkJCWw4LjgtMzNsOTkuNiw3OC4yVjUzOUwtMTkxLjksNjQ3di02MS4zbDk1LTcyLjdsLTY5LjQsMC4xTC0xOTEuOSw1MTMuMnoiLz4NCgk8L2c+DQo8L2c+DQo8L3N2Zz4NCg==',
    25
  );

  add_submenu_page(null, 'Code9 layout editor', 'Code9 layout editor', 'edit_posts', 'code9-page-editor', 'code9_page_editor');
}

add_action('admin_menu', 'code9_menu_page');


?>