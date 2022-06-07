<template>
  <div id="app" class="wl">
    <router-view/>
  </div>
</template>
<script>
</script>
<style>
html,body{
	overflow-x:hidden;
}
#app{
  font-family: '黑体', Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #282828;
  height: 100%;
}
.wl{
  max-width:500px;margin:0 auto;overflow-x:hidden;
}
.shadow1{box-shadow:0px 0.5px 0.8px #E3E3E3;}
.tc1{color:#282828;}
.tc2{color:#9B9B9B;}
.tc3{color:#D7D7D7;}
.yshadow{filter: drop-shadow(0px 2px 2px #B4B4B3);}
</style>
