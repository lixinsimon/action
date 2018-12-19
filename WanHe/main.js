import Vue from 'vue'
import App from './App'

Vue.config.productionTip = false
App.mpType = 'app'



// 
// //跳转到新页面 <a>==================================================
//  var  navigate= Vue.extend({
// 	template: "<navigator url='url'>{{url}}<slot></slot></navigator>",
// 	props:['url']	
// })
// Vue.component('n', navigate);
// //在当前页打开 <a>==================================================
//  var  redirect= Vue.extend({
// 	template: "<navigator :url='u' redirect><slot></slot></navigator>",
// 	props:['u']	
// })
// Vue.component('r', redirect);
// // <a>==================================================
//  var  switchTab= Vue.extend({
// 	template: "<navigator :url='u' switchTab><slot></slot></navigator>",
// 	props:['u']	
// })
// Vue.component('s', switchTab);


//初始化==================================================
const app = new Vue({	
	...App
})
app.$mount()
