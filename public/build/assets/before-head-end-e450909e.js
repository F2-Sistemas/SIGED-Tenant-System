document.addEventListener("alpine:init",()=>{const n=e=>e<=700?"mobile":e<=1024?"medium":e<=2048?"large":e>2048?"extra large":"";Alpine.store("windowWidth",window.innerWidth),Alpine.store("windowHeight",window.innerHeight),Alpine.store("screenType",n(window.innerWidth)),Alpine.store("screenInfo",{width:window.innerWidth,height:window.innerHeight,screenType:n(window.innerWidth),isMediumOrLess:()=>window.innerHeight<=1024,isMobile:()=>window.innerHeight<=700}),new ResizeObserver(e=>{const t={width:e[0].contentRect.width,height:e[0].contentRect.height,screenType:n(e[0].contentRect.width),isMediumOrLess:()=>e[0].contentRect.width<=1024,isMobile:()=>e[0].contentRect.width<=700};Alpine.store("screenInfo",{...t}),Alpine.store("windowWidth",e[0].contentRect.width),Alpine.store("windowHeight",e[0].contentRect.height),Alpine.store("screenType",n(e[0].contentRect.width))}).observe(document.body)});
