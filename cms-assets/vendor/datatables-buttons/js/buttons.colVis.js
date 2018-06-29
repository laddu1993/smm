!function(n){"function"==typeof define&&define.amd?define(["jquery","datatables.net","datatables.net-buttons"],function(t){return n(t,window,document)}):"object"==typeof exports?module.exports=function(t,o){return t||(t=window),o&&o.fn.dataTable||(o=require("datatables.net")(t,o).$),o.fn.dataTable.Buttons||require("datatables.net-buttons")(t,o),n(o,t,t.document)}:n(jQuery,window,document)}(function(n,t,o,i){"use strict";var e=n.fn.dataTable;return n.extend(e.ext.buttons,{colvis:function(n,t){return{extend:"collection",text:function(n){return n.i18n("buttons.colvis","Column visibility")},className:"buttons-colvis",buttons:[{extend:"columnsToggle",columns:t.columns}]}},columnsToggle:function(n,t){return n.columns(t.columns).indexes().map(function(n){return{extend:"columnToggle",columns:n}}).toArray()},columnToggle:function(n,t){return{extend:"columnVisibility",columns:t.columns}},columnsVisibility:function(n,t){return n.columns(t.columns).indexes().map(function(n){return{extend:"columnVisibility",columns:n,visibility:t.visibility}}).toArray()},columnVisibility:{columns:i,text:function(n,t,o){return o._columnText(n,o.columns)},className:"buttons-columnVisibility",action:function(n,t,o,e){var s=t.columns(e.columns),u=s.visible();s.visible(e.visibility!==i?e.visibility:!(u.length&&u[0]))},init:function(n,t,o){var i=this;n.on("column-visibility.dt"+o.namespace,function(t,e){e.bDestroying||i.active(n.column(o.columns).visible())}).on("column-reorder.dt"+o.namespace,function(t,e,s){if(1===n.columns(o.columns).count()){"number"==typeof o.columns&&(o.columns=s.mapping[o.columns]);var u=n.column(o.columns);i.text(o._columnText(n,o.columns)),i.active(u.visible())}}),this.active(n.column(o.columns).visible())},destroy:function(n,t,o){n.off("column-visibility.dt"+o.namespace).off("column-reorder.dt"+o.namespace)},_columnText:function(n,t){var o=n.column(t).index();return n.settings()[0].aoColumns[o].sTitle.replace(/\n/g," ").replace(/<.*?>/g,"").replace(/^\s+|\s+$/g,"")}},colvisRestore:{className:"buttons-colvisRestore",text:function(n){return n.i18n("buttons.colvisRestore","Restore visibility")},init:function(n,t,o){o._visOriginal=n.columns().indexes().map(function(t){return n.column(t).visible()}).toArray()},action:function(n,t,o,i){t.columns().every(function(n){var o=t.colReorder&&t.colReorder.transpose?t.colReorder.transpose(n,"toOriginal"):n;this.visible(i._visOriginal[o])})}},colvisGroup:{className:"buttons-colvisGroup",action:function(n,t,o,i){t.columns(i.show).visible(!0,!1),t.columns(i.hide).visible(!1,!1),t.columns.adjust()},show:[],hide:[]}}),e.Buttons});