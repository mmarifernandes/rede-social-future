<html>
  <body>
      <style>
          html, body {
  background: #e9ebee;
  height: 100%;
}

.container-box {
  width: 100%;
  height: 100%;
  display: grid;
  grid-template-columns: auto 200px;
  grid-template-rows: 40px 1fr;
  grid-template-areas:
    'header header'
    'main aside'
    'footer footer'
  ;
}

.header {
  grid-area: header;
  background: #3b5998;
}

.main {
  grid-area: main;
  display: grid;
  grid-template-columns: 150px minmax(100px,1fr) 200px;
  grid-template-rows: auto;
  grid-template-areas: 'menu feed event';
  grid-gap: 10px;
  padding: 10px 40px;
}

.aside {
  grid-area: aside;
  border-left: 2px solid #ccc;
}

.menu {
  grid-area: menu;
}

.feed {
  grid-area: feed;
  background: #fff;
}

.event {
  grid-area: event;
  background: #fff;
}

      </style>
  <div class="container-box">
    <header class="header"></header>
    <main class="main">
      <section class="menu"></section>
      <section class="feed"></section>
      <section class="event"></section>
    </main>
    <aside class="aside"></aside>
  </div>
</body>
</html>