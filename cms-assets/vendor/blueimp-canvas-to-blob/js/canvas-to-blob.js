!function(t){"use strict";var e=t.HTMLCanvasElement&&t.HTMLCanvasElement.prototype,o=t.Blob&&function(){try{return Boolean(new Blob)}catch(t){return!1}}(),n=o&&t.Uint8Array&&function(){try{return 100===new Blob([new Uint8Array(100)]).size}catch(t){return!1}}(),r=t.BlobBuilder||t.WebKitBlobBuilder||t.MozBlobBuilder||t.MSBlobBuilder,a=(o||r)&&t.atob&&t.ArrayBuffer&&t.Uint8Array&&function(t){var e,a,i,l,u,b,c,d,B;if(!(e=t.match(/^data:((.*?)(;charset=.*?)?)(;base64)?,/)))throw new Error("invalid data URI");for(a=e[2]?e[1]:"text/plain"+(e[3]||";charset=US-ASCII"),i=!!e[4],l=t.slice(e[0].length),u=i?atob(l):decodeURIComponent(l),b=new ArrayBuffer(u.length),c=new Uint8Array(b),d=0;d<u.length;d+=1)c[d]=u.charCodeAt(d);return o?new Blob([n?c:b],{type:a}):(B=new r,B.append(b),B.getBlob(a))};t.HTMLCanvasElement&&!e.toBlob&&(e.mozGetAsFile?e.toBlob=function(t,o,n){t(n&&e.toDataURL&&a?a(this.toDataURL(o,n)):this.mozGetAsFile("blob",o))}:e.toDataURL&&a&&(e.toBlob=function(t,e,o){t(a(this.toDataURL(e,o)))})),"function"==typeof define&&define.amd?define(function(){return a}):"object"==typeof module&&module.exports?module.exports=a:t.dataURLtoBlob=a}(window);