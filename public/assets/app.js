(function(){
  'use strict';
  var App={state:null,ui:null,step:1,isTransitioning:false,hasBootstrapped:false,lastInputWasKeyboard:false,replaceIndex:null,waitTimer:null,progressTimer:null,terminalTimer:null,galleryIndex:0,savedPhotoSets:[],savedPhotoSetsRefreshId:0};
  var $=function(s){return document.querySelector(s)}, $$=function(s){return Array.prototype.slice.call(document.querySelectorAll(s))};

  function api(action, opts){
    opts=opts||{}; var url='api.php?action='+encodeURIComponent(action);
    return fetch(url,{method:opts.method||'GET',body:opts.body||null,credentials:'same-origin',headers:opts.headers||{}}).then(function(r){return r.json().then(function(j){if(!r.ok||j.ok===false&&opts.strict!==false) throw new Error(j.message||'Serverfehler');return j;});});
  }
  function toast(msg,actionLabel,action){var t=$('#toast');t.innerHTML='';var text=document.createElement('span');text.textContent=msg;t.appendChild(text);if(actionLabel&&action){var button=document.createElement('button');button.type='button';button.textContent=actionLabel;button.onclick=function(){t.classList.remove('show');action()};t.appendChild(button)}t.classList.add('show');setTimeout(function(){t.classList.remove('show')},action?12000:5200)}
  function gotoStep(n){
    n=parseInt(n,10);var target=$('.stage[data-step="'+n+'"]'),current=$('.stage.active');
    if(!target){App.isTransitioning=false;return}
    function updateStepper(){$$('[data-step-nav]').forEach(function(el){var x=parseInt(el.getAttribute('data-step-nav'),10);el.classList.toggle('active',x===n);el.classList.toggle('done',x<n)})}
    function focusHeading(){var heading=target.querySelector('h1');if(!heading)return;heading.setAttribute('tabindex','-1');heading.classList.toggle('pointer-focus',!App.lastInputWasKeyboard);heading.focus({preventScroll:true});heading.removeAttribute('tabindex');heading.addEventListener('blur',function(){heading.classList.remove('pointer-focus')},{once:true})}
    function showImmediately(){$$('.stage').forEach(function(el){el.classList.remove('active','stage-exiting','stage-exit-active','stage-entering','stage-entered','to-next','to-prev')});target.classList.add('active');App.step=n;updateStepper();App.isTransitioning=false;window.scrollTo({top:0,behavior:'auto'});if(App.hasBootstrapped)focusHeading();App.hasBootstrapped=true}
    if(n===App.step){updateStepper();App.hasBootstrapped=true;return}
    if(App.isTransitioning)return;
    if(!App.hasBootstrapped||!current||window.matchMedia('(prefers-reduced-motion: reduce)').matches){showImmediately();return}
    App.isTransitioning=true;var forward=n>App.step,direction=forward?'to-next':'to-prev',container=$('.stage-container');
    container.style.minHeight=current.offsetHeight+'px';current.classList.add('stage-exiting',direction);window.requestAnimationFrame(function(){current.classList.add('stage-exit-active')});
    setTimeout(function(){
      current.classList.remove('active','stage-exiting','stage-exit-active',direction);App.step=n;updateStepper();target.classList.add('active','stage-entering',direction);
      var lead=target.querySelector('.lead'),pieces=[target.querySelector('.eyebrow'),target.querySelector('h1'),lead,lead&&lead.nextElementSibling];pieces.forEach(function(el,i){if(el){el.classList.add('stage-content-enter');el.style.setProperty('--content-delay',(i*45)+'ms')}});
      var nav=$('[data-step-nav="'+n+'"]'),connector=nav&&(forward?nav.previousElementSibling:nav.nextElementSibling);if(connector&&connector.tagName==='I')connector.classList.add('connector-building');else connector=null;
      target.offsetWidth;target.classList.add('stage-entered');if(connector)connector.classList.add('connector-built');
      setTimeout(function(){target.classList.remove('stage-entering','stage-entered',direction);pieces.forEach(function(el){if(el){el.classList.remove('stage-content-enter');el.style.removeProperty('--content-delay')}});if(connector)connector.classList.remove('connector-building','connector-built');container.style.removeProperty('min-height');App.isTransitioning=false;window.scrollTo({top:0,behavior:'smooth'});focusHeading()},415);
    },180);
  }
  function optionFill(el, options, placeholder, fallback){
    options=options&&options.length?options:(fallback||[]);el.innerHTML='';var p=document.createElement('option');p.value='';p.textContent=placeholder;p.disabled=true;p.selected=true;el.appendChild(p);
    options.forEach(function(o){var op=document.createElement('option');op.value=String(o.value);op.textContent=String(o.label);el.appendChild(op)});
  }
  function findLabel(select){return select.options[select.selectedIndex]?select.options[select.selectedIndex].text:''}
  function isOutside(text){text=(text||'').toLowerCase();return text.indexOf('auß')>=0||text.indexOf('auss')>=0||text.indexOf('outdoor')>=0||/^a(?:\s|[-_.:0-9])/.test(text)}

  function uploadSlot(i){return 'SRC '+String(i+1).padStart(2,'0')}
  function announceUpload(message){var live=$('#upload-status');if(live){live.textContent='';setTimeout(function(){live.textContent=message},20)}}
  function markUploadError(){var zone=$('#drop-zone');zone.classList.remove('upload-error');zone.offsetWidth;zone.classList.add('upload-error');setTimeout(function(){zone.classList.remove('upload-error')},240)}
  function bindUploadCard(card,u){
    card.querySelector('.replace').onclick=function(e){e.stopPropagation();App.replaceIndex=u.id;var input=$('#photo-input');input.multiple=false;input.click()};
    card.querySelector('.remove').onclick=function(e){e.stopPropagation();var fd=new FormData();fd.append('upload_id',u.id);api('remove_upload',{method:'POST',body:fd}).then(function(r){
      var removedSlot=Array.prototype.indexOf.call(card.parentNode.children,card)+1,finish=function(){App.state=r.state;renderUploads(null,'remove');renderPhotoSetHistory();renderWaitReferences();announceUpload('Referenzfoto '+removedSlot+' entfernt')};
      if(window.matchMedia('(prefers-reduced-motion: reduce)').matches)finish();else{card.classList.add('upload-removing');setTimeout(finish,160)}
    }).catch(function(e2){markUploadError();toast(e2.message)})};
  }
  function populateUploadCard(card,u,i){
    card.setAttribute('data-upload-id',u.id);var img=card.querySelector('img');img.alt='Referenzfoto '+(i+1);img.src=u.url;
    card.querySelector('.slot').textContent=uploadSlot(i);card.querySelector('.card-foot span:first-child').textContent=u.name;card.querySelector('.card-foot span:last-child').textContent=Math.round(u.size/1024)+' KB';bindUploadCard(card,u);
  }
  function lockUploadCard(card,u,i,delay,keepGeometry){
    var reduced=window.matchMedia('(prefers-reduced-motion: reduce)').matches, mobile=window.matchMedia('(max-width: 560px)').matches,slot=card.querySelector('.slot'),foot=card.querySelector('.card-foot');
    slot.textContent='SYNCING';if(reduced){slot.textContent=uploadSlot(i);announceUpload('Referenzfoto '+(i+1)+' erfolgreich hochgeladen');return}
    card.style.setProperty('--upload-delay',delay+'ms');card.classList.add(keepGeometry?'upload-lock':'upload-reveal');requestAnimationFrame(function(){requestAnimationFrame(function(){card.classList.add(keepGeometry?'upload-lock-active':'upload-reveal-active')})});
    setTimeout(function(){slot.textContent=mobile?uploadSlot(i)+' · LOCKED':uploadSlot(i);if(!mobile){foot.classList.add('identity-locked');foot.textContent='IDENTITY SOURCE · LOCKED'}announceUpload('Referenzfoto '+(i+1)+' erfolgreich hochgeladen')},delay+420);
    setTimeout(function(){slot.textContent=uploadSlot(i);foot.classList.remove('identity-locked');foot.innerHTML='<span></span><span></span>';foot.querySelector('span:first-child').textContent=u.name;foot.querySelector('span:last-child').textContent=Math.round(u.size/1024)+' KB';card.classList.remove('upload-reveal','upload-reveal-active','upload-lock','upload-lock-active');card.style.removeProperty('--upload-delay')},delay+1320);
  }
  function renderUploads(changedId,changeType,replacedId){
    var grid=$('#upload-grid'),uploads=App.state&&App.state.uploads?App.state.uploads:[],changed=Array.isArray(changedId)?changedId:(changedId?[changedId]:[]),existing={};
    Array.prototype.forEach.call(grid.children,function(card){existing[card.getAttribute('data-upload-id')]=card});
    uploads.forEach(function(u,i){
      var isChanged=changed.indexOf(u.id)>=0,card=existing[u.id];
      if(!card&&changeType==='replace'&&isChanged&&replacedId)card=existing[replacedId];
      if(!card){card=document.createElement('div');card.className='image-card';card.innerHTML='<img><span class="slot"></span><div class="card-actions"><button class="mini-btn replace" type="button">TAUSCHEN</button><button class="mini-btn remove" type="button" aria-label="Referenzfoto entfernen">×</button></div><div class="card-foot"><span></span><span></span></div>'}
      delete existing[u.id];if(replacedId)delete existing[replacedId];
      if(changeType==='replace'&&isChanged&&!window.matchMedia('(prefers-reduced-motion: reduce)').matches){card.querySelector('.slot').textContent='SYNCING';card.classList.add('upload-replacing');setTimeout(function(){populateUploadCard(card,u,i);card.querySelector('.slot').textContent='SYNCING';requestAnimationFrame(function(){card.classList.add('upload-replacing-in')});setTimeout(function(){card.classList.remove('upload-replacing','upload-replacing-in');lockUploadCard(card,u,i,0,true)},260)},140)}else{populateUploadCard(card,u,i);if(isChanged)lockUploadCard(card,u,i,window.matchMedia('(max-width: 560px)').matches?0:changed.indexOf(u.id)*70)}
      grid.appendChild(card);
    });
    Object.keys(existing).forEach(function(id){existing[id].remove()});
    $('#generate-photoset').disabled=App.uploading||uploads.length<1;
  }
  function decryptGlyphs(seed){var chars='01ZXCVBNMASDFGHJKLQWERTYUIOPアイウエオカキクケコサシスセソ';var out='',len=180;for(var i=0;i<len;i++){out+=chars.charAt((i*7+seed*13+Math.floor(Math.random()*chars.length))%chars.length);if((i+1)%18===0)out+='\n';}return out;}
  function addDecryptLayer(card,index,kind){
    card.classList.add('decrypt-card','decrypt-pending');
    card.style.setProperty('--decrypt-delay',(index*(kind==='scene'?260:210))+'ms');
    var layer=document.createElement('div');layer.className='decrypt-layer';
    var code=document.createElement('pre');code.className='decrypt-code';code.textContent=decryptGlyphs(index+1);
    var scan=document.createElement('i');scan.className='decrypt-scan';
    var label=document.createElement('span');label.className='decrypt-label';label.textContent='ENCRYPTED';
    layer.appendChild(code);layer.appendChild(scan);layer.appendChild(label);card.appendChild(layer);
  }
  function runDecryptReveal(container,kind){
    if(!container)return;var cards=Array.prototype.slice.call(container.querySelectorAll('.decrypt-card'));
    cards.forEach(function(card,index){var img=card.querySelector('img'),delay=280+index*(kind==='scene'?260:210);var begin=function(){setTimeout(function(){card.classList.remove('decrypt-pending');card.classList.add('decrypting');var label=card.querySelector('.decrypt-label');if(label)label.textContent='DECRYPTING';setTimeout(function(){card.classList.add('decrypt-ready');if(label)label.textContent='READY';setTimeout(function(){card.classList.remove('decrypting');},900);},1450);},delay);};if(img&&img.complete&&img.naturalWidth>0)begin();else if(img){img.addEventListener('load',begin,{once:true});img.addEventListener('error',begin,{once:true});}else begin();});
  }
  function renderPhotoSet(urls,reveal){urls=urls||[];var grid=$('#photoset-grid');grid.innerHTML='';urls.forEach(function(url,i){var card=document.createElement('div');card.className='image-card';card.innerHTML='<img alt="FotoSet '+(i+1)+'"><span class="slot">SET '+String(i+1).padStart(2,'0')+'</span><div class="card-foot"><span>IDENTITY VARIANT</span><span>READY</span></div>';if(reveal)addDecryptLayer(card,i,'photoset');var img=card.querySelector('img');img.src=url;grid.appendChild(card)});if(reveal)runDecryptReveal(grid,'photoset');var approve=$('#approve-photoset');if(approve)approve.disabled=urls.length<1}
  function photosetAttempts(){return App.state&&App.state.photoset_attempts?App.state.photoset_attempts:[]}
  function activeAttemptIndex(){var a=photosetAttempts(),id=App.state?App.state.active_photoset_attempt_id:null;for(var i=0;i<a.length;i++)if(String(a[i].id)===String(id))return i;return -1}
  function formatAttemptTime(value){if(!value)return '';var d=new Date(value);if(isNaN(d.getTime()))return '';return d.toLocaleString('de-DE',{day:'2-digit',month:'2-digit',hour:'2-digit',minute:'2-digit'})}
  function renderPhotoSetHistory(){
    var attempts=photosetAttempts(),history=$('#photoset-history'),browser=$('#photoset-browser'),shortcut=$('#photoset-history-shortcut'),count=$('#photoset-history-count');
    if(count)count.textContent=attempts.length+' FotoSetCard'+(attempts.length===1?'':'s')+' gespeichert';
    if(shortcut)shortcut.classList.toggle('hidden',attempts.length<1);
    if(browser)browser.classList.toggle('hidden',attempts.length<1);
    if(!history)return;history.innerHTML='';
    attempts.forEach(function(a,i){
      var card=document.createElement('button');card.type='button';card.className='history-card'+(a.active?' active':'')+(a.approved?' approved':'');card.setAttribute('data-attempt-id',a.id);
      var previews=document.createElement('span');previews.className='history-previews';
      (a.images||[]).slice(0,4).forEach(function(url){var img=document.createElement('img');img.src=url;img.alt='';previews.appendChild(img)});
      while(previews.children.length<4){var blank=document.createElement('i');previews.appendChild(blank)}
      var meta=document.createElement('span');meta.className='history-meta';
      var title=document.createElement('strong');title.textContent='Versuch '+String(a.number||i+1).padStart(2,'0');meta.appendChild(title);
      var sub=document.createElement('small');sub.textContent=(a.image_count||0)+' Bilder · '+formatAttemptTime(a.created_at);meta.appendChild(sub);
      if(a.approved){var badge=document.createElement('em');badge.textContent='VERWENDET';meta.appendChild(badge)}
      card.appendChild(previews);card.appendChild(meta);card.onclick=function(){selectPhotoSetAttempt(a.id)};history.appendChild(card);
    });
    var idx=activeAttemptIndex();if(idx<0&&attempts.length)idx=attempts.length-1;
    var pos=$('#photoset-position'),created=$('#photoset-created');
    if(pos)pos.textContent=attempts.length?('Versuch '+(idx+1)+' von '+attempts.length):'Kein Versuch gespeichert';
    if(created)created.textContent=attempts.length&&attempts[idx]?formatAttemptTime(attempts[idx].created_at):'';
    if($('#photoset-prev'))$('#photoset-prev').disabled=idx<=0;
    if($('#photoset-next'))$('#photoset-next').disabled=idx<0||idx>=attempts.length-1;
  }
  function selectPhotoSetAttempt(id){var fd=new FormData();fd.append('attempt_id',id);return api('select_photoset_attempt',{method:'POST',body:fd}).then(function(r){App.state=r.state;renderPhotoSet(App.state.photoset_images);renderPhotoSetHistory();gotoStep(2);return r}).catch(function(e){toast(e.message)})}
  function selectPhotoSetOffset(delta){var attempts=photosetAttempts();if(!attempts.length)return;var idx=activeAttemptIndex();if(idx<0)idx=attempts.length-1;idx=Math.max(0,Math.min(attempts.length-1,idx+delta));selectPhotoSetAttempt(attempts[idx].id)}
  function renderSavedPhotoSets(items){App.savedPhotoSets=items||[];var grid=$('#photoset-library-grid'),count=$('#saved-photoset-count');if(count)count.textContent=App.savedPhotoSets.length?(App.savedPhotoSets.length+' gespeicherte'+(App.savedPhotoSets.length===1?'s FotoSet':' FotoSets')):'Noch keine gespeicherten FotoSets';if(!grid)return;grid.innerHTML='';if(!App.savedPhotoSets.length){var empty=document.createElement('div');empty.className='photoset-library-empty';empty.innerHTML='<strong>Noch keine FotoSets im Storage</strong>Nach der ersten erfolgreichen FotoSet-Generierung erscheint das Set automatisch hier.';grid.appendChild(empty);return}App.savedPhotoSets.forEach(function(set,i){var card=document.createElement('button');card.type='button';card.className='photoset-library-card';var previews=document.createElement('span');previews.className='photoset-library-previews';(set.images||[]).slice(0,4).forEach(function(url){var img=document.createElement('img');img.src=url;img.alt='';previews.appendChild(img)});while(previews.children.length<4){var blank=document.createElement('i');previews.appendChild(blank)}var meta=document.createElement('span');meta.className='photoset-library-meta';var info=document.createElement('span');var title=document.createElement('strong');title.textContent='FotoSet '+String(i+1).padStart(2,'0');var sub=document.createElement('small');sub.textContent=(set.image_count||0)+' Bilder · '+formatAttemptTime(set.created_at);info.appendChild(title);info.appendChild(sub);var arrow=document.createElement('b');arrow.textContent='→';meta.appendChild(info);meta.appendChild(arrow);card.appendChild(previews);card.appendChild(meta);card.onclick=function(){selectSavedPhotoSet(set.id)};grid.appendChild(card)})}
  function refreshSavedPhotoSets(openAfter){var refreshId=++App.savedPhotoSetsRefreshId;return api('list_saved_photosets').then(function(r){if(refreshId===App.savedPhotoSetsRefreshId)renderSavedPhotoSets(r.photosets||[]);if(openAfter)openSavedPhotoSets();return {ok:true,response:r}}).catch(function(e){if(openAfter)toast(e.message);return {ok:false,error:e}})}
  function openSavedPhotoSets(){$('#photoset-library-modal').classList.add('open');$('#photoset-library-modal').setAttribute('aria-hidden','false');document.body.style.overflow='hidden'}
  function closeSavedPhotoSets(){$('#photoset-library-modal').classList.remove('open');$('#photoset-library-modal').setAttribute('aria-hidden','true');if(!$('#gallery-modal').classList.contains('open'))document.body.style.overflow=''}
  function selectSavedPhotoSet(id){var fd=new FormData();fd.append('library_id',id);startWait('photoset');$('#wait-title').textContent='Gespeichertes FotoSet wird geladen';$('#wait-message').textContent='Bilder werden aus dem lokalen Storage übernommen …';api('select_saved_photoset',{method:'POST',body:fd}).then(function(r){stopWait();closeSavedPhotoSets();App.state=r.state;renderPhotoSet(App.state.photoset_images);renderPhotoSetHistory();gotoStep(2)}).catch(function(e){stopWait();toast(e.message)})}
  function renderFinal(results,reveal){var grid=$('#final-grid');grid.innerHTML='';(results||[]).forEach(function(r,i){var card=document.createElement('button');card.type='button';card.className='image-card contain';card.innerHTML='<img alt="Ergebnis '+(i+1)+'"><span class="slot">SCENE '+String(i+1).padStart(2,'0')+'</span><div class="card-foot"><span></span><span>VEHABI</span></div>';if(reveal)addDecryptLayer(card,i,'scene');var img=card.querySelector('img');img.src=r.url;card.querySelector('.card-foot span:first-child').textContent=r.scene;card.onclick=function(){if(card.classList.contains('decrypt-pending')||card.classList.contains('decrypting'))return;openGallery(i)};grid.appendChild(card)});if(reveal)runDecryptReveal(grid,'scene')}
  function renderScenes(options){
    var wrap=$('#scene-options');wrap.innerHTML='';(options||[]).forEach(function(o,i){var label=document.createElement('label');label.className='scene-option';label.innerHTML='<input type="checkbox" name="scenes[]"><span></span>';label.querySelector('input').value=o.value;label.querySelector('span').textContent=o.label;label.querySelector('input').addEventListener('change',sceneCount);wrap.appendChild(label)});sceneCount();
  }
  function sceneCount(){var checks=$$('#scene-options input'), selected=checks.filter(function(x){return x.checked});checks.forEach(function(x){x.disabled=!x.checked&&selected.length>=3});$('#scene-count').textContent=selected.length+' / 3 gewählt';$('#scene-meter').style.width=(selected.length/3*100)+'%';$('#start-scenes').disabled=selected.length!==3;}

  function galleryItems(){return App.state&&App.state.scene_results?App.state.scene_results:[]}
  function updateGallery(){var items=galleryItems(),index=App.galleryIndex;if(!items.length)return closeGallery();if(index<0)index=0;if(index>=items.length)index=items.length-1;App.galleryIndex=index;var item=items[index];$('#gallery-image').src=item.url;$('#gallery-image').alt=item.scene||('Szene '+(index+1));$('#gallery-title').textContent=item.scene||('Szene '+(index+1));$('#gallery-meta').textContent='Bild '+(index+1)+' von '+items.length;var thumbs=$('#gallery-thumbs');thumbs.innerHTML='';items.forEach(function(entry,i){var btn=document.createElement('button');btn.type='button';btn.className='gallery-thumb'+(i===index?' active':'');btn.innerHTML='<img alt=""><span></span>';btn.querySelector('img').src=entry.url;btn.querySelector('img').alt=entry.scene||('Szene '+(i+1));btn.querySelector('span').textContent=entry.scene||('Szene '+(i+1));btn.onclick=function(){App.galleryIndex=i;updateGallery()};thumbs.appendChild(btn)});$('#gallery-prev').disabled=index<=0;$('#gallery-next').disabled=index>=items.length-1;}
  function openGallery(index){var items=galleryItems();if(!items.length)return;App.galleryIndex=index||0;$('#gallery-modal').classList.add('open');$('#gallery-modal').setAttribute('aria-hidden','false');document.body.style.overflow='hidden';updateGallery()}
  function closeGallery(){$('#gallery-modal').classList.remove('open');$('#gallery-modal').setAttribute('aria-hidden','true');document.body.style.overflow='';}
  function shiftGallery(delta){var items=galleryItems();if(!items.length)return;App.galleryIndex=Math.max(0,Math.min(items.length-1,App.galleryIndex+delta));updateGallery()}

  function configureUi(data){
    App.ui=data.ui;App.state=data.state;var o=data.ui.options||{};
    optionFill($('#gender'),o.gender,'Bitte wählen',[{value:'Mann',label:'Mann'},{value:'Frau',label:'Frau'}]);
    optionFill($('#clothing'),o.clothing,'Kleidungsstil aus Projekt 18 wählen');
    optionFill($('#image-style'),o.image_style,'Bildstil aus Projekt 18 wählen');
    optionFill($('#location'),o.location,'Location-Kategorie aus Projekt 18 wählen');
    optionFill($('#region'),o.region,'Region aus Projekt 18 wählen');
    renderScenes(o.scene||[]);renderUploads();renderPhotoSet(App.state.photoset_images);renderPhotoSetHistory();renderFinal(App.state.scene_results);if(!(App.state.scene_results&&App.state.scene_results.length))closeGallery();
    if(App.state.profile){if(App.state.profile.height)$('#height').value=App.state.profile.height;setValue($('#gender'),App.state.profile.gender);setValue($('#clothing'),App.state.profile.clothing);setValue($('#image-style'),App.state.profile.image_style)}
    if(App.state.location&&App.state.location.value){setValue($('#location'),App.state.location.value);setValue($('#region'),App.state.location.region);toggleRegion()}
    if(App.state.scene_results&&App.state.scene_results.length===3)gotoStep(6);else if(App.state.photoset_approved&&App.state.scenes&&App.state.scenes.length===3)gotoStep(5);else if(App.state.photoset_approved&&App.state.location&&App.state.location.value)gotoStep(5);else if(App.state.photoset_approved&&App.state.profile&&App.state.profile.height)gotoStep(4);else if(App.state.photoset_approved)gotoStep(3);else if(App.state.photoset_images&&App.state.photoset_images.length)gotoStep(2);else gotoStep(1);
  }
  function setValue(el,val){if(val===undefined||val===null)return;Array.prototype.some.call(el.options,function(o){if(String(o.value)===String(val)){el.value=o.value;return true}return false})}

  function toggleRegion(){var txt=findLabel($('#location'))+' '+$('#location').value;var outside=isOutside(txt);$('#region-wrap').classList.toggle('hidden',!outside);$('#region').required=outside;$('#category-hint').textContent=outside?'Gruppe A aktiv · für Außenaufnahmen ist zusätzlich eine Region erforderlich.':'Szenengruppe wird anhand dieser Kategorie gefiltert.';}

  function waitMessages(kind){
    return kind==='scenes'
      ? ['FotoSet wird als Referenz gebunden …','Projekt 18 wird aufgelöst …','Drei Vehabi-Läufe wurden parallel gestartet …','Location und Bildstil werden angewendet …','Szenenkontext wird rekonstruiert …','Visual Consistency Pass aktiv …','Szenenbilder werden lokal synchronisiert …']
      : ['Referenzbilder werden sicher übertragen …','Projekt 23 wird vorbereitet …','Gesicht und Erscheinungsbild werden abgeglichen …','Identitätsmerkmale werden analysiert …','Visuelle Konsistenz wird stabilisiert …','Vier Ergebnisvarianten werden vorbereitet …','FotoSetCards werden lokal zwischengespeichert …'];
  }
  function waitViews(){return App.waitKind==='photoset'?['references','identity','biometric','helix','landmarks','forge','vector','memory','entropy','shards','checksum','vault','matrix','terminal']:['references','identity','matrix','terminal'];}
  function waitViewLabel(name){var labels={references:'REFERENCES',identity:'IDENTITY',biometric:'BIOMETRIC RADAR',helix:'IDENTITY HELIX',landmarks:'LANDMARK CONSTELLATION',forge:'PIXEL FORGE',vector:'VECTOR LOCK',memory:'MEMORY LATTICE',entropy:'ENTROPY FILTER',shards:'IDENTITY SHARDS',checksum:'CONSISTENCY CHECKSUM',vault:'SYNTHESIS VAULT',matrix:'MATRIX',terminal:'TERMINAL'};return labels[name]||String(name).toUpperCase();}
  function renderWaitPageDots(){var wrap=$('#wait-page-dots');if(!wrap)return;var views=waitViews();wrap.innerHTML='';views.forEach(function(v,i){var dot=document.createElement('i');dot.className=i===App.waitViewIndex?'active':'';wrap.appendChild(dot)});var meta=$('#wait-auto-meta');if(meta)meta.textContent='AUTO '+String(App.waitViewIndex+1).padStart(2,'0')+' / '+String(views.length).padStart(2,'0');}
  function setWaitView(name){var views=waitViews(),idx=views.indexOf(name);if(idx>=0)App.waitViewIndex=idx;$$('[data-wait-view]').forEach(function(btn){btn.classList.toggle('active',btn.getAttribute('data-wait-view')===name)});$$('.wait-view').forEach(function(view){view.classList.toggle('active',view.getAttribute('data-view')===name)});var note=$('#wait-visual-note');if(note)note.textContent=name==='terminal'?'LIVE STATUS FEED':waitViewLabel(name);renderWaitPageDots();}
  function rotateWaitView(){var views=waitViews();App.waitViewIndex=(App.waitViewIndex+1)%views.length;setWaitView(views[App.waitViewIndex]);}
  function shiftWaitView(delta){var views=waitViews();App.waitViewIndex=(App.waitViewIndex+delta+views.length)%views.length;setWaitView(views[App.waitViewIndex]);}
  function waitReferenceSources(){
    var uploads=(App.state&&App.state.uploads?App.state.uploads:[]).filter(function(x){return x&&x.url});
    var photoset=(App.state&&App.state.photoset_images?App.state.photoset_images:[]).filter(function(x){return !!x});
    var list=[];
    if(App.waitKind==='scenes' && photoset.length){
      list.push({key:'photoset',title:'Freigegebene FotoSetCard',chip:'PHOTOSET CARD',hint:'Dieses freigegebene FotoSet wird aktuell als Referenz für die drei Szenen verwendet.',items:photoset.slice(0,4).map(function(url,i){return {url:url,label:'SET '+String(i+1).padStart(2,'0'),name:'Approved Set '+(i+1),kind:'photoset'}})});
    }
    if(uploads.length){
      list.push({key:'uploads',title:App.waitKind==='scenes'?'Ursprüngliche Referenz-Uploads':'Hochgeladene Referenzbilder',chip:'SOURCE INPUT',hint:App.waitKind==='scenes'?'Zum Vergleich werden zyklisch auch die ursprünglichen Uploads gezeigt, aus denen das FotoSet entstanden ist.':'Diese Uploads werden gerade analysiert und zum FotoSet zusammengeführt.',items:uploads.slice(0,4).map(function(item,i){return {url:item.url,label:'SRC '+String(i+1).padStart(2,'0'),name:item.name||('Referenz '+(i+1)),kind:'upload'}})});
    }
    if(!list.length && photoset.length){
      list.push({key:'photoset',title:'Aktive FotoSetCard',chip:'PHOTOSET CARD',hint:'Das aktuelle FotoSet ist geladen und steht für die weitere Verarbeitung bereit.',items:photoset.slice(0,4).map(function(url,i){return {url:url,label:'SET '+String(i+1).padStart(2,'0'),name:'Set '+(i+1),kind:'photoset'}})});
    }
    if(!list.length){
      list.push({key:'empty',title:'Warte auf Referenzmaterial',chip:'NO SOURCE',hint:'Sobald Referenzbilder vorliegen, werden sie hier mit Matrix-Effekt dargestellt.',items:[]});
    }
    return list;
  }
  function renderWaitReferences(forceIndex){var grid=$('#wait-reference-grid');if(!grid)return;var sources=waitReferenceSources();if(typeof forceIndex==='number')App.waitReferenceSourceIndex=forceIndex;if(App.waitReferenceSourceIndex>=sources.length)App.waitReferenceSourceIndex=0;var source=sources[App.waitReferenceSourceIndex]||sources[0];grid.classList.add('switching');setTimeout(function(){grid.classList.remove('switching')},260);grid.innerHTML='';for(var i=0;i<4;i++){var item=source.items[i];var card=document.createElement('div');card.className='wait-ref-card'+(item?'':' placeholder')+(item&&item.kind==='photoset'?' photoset':'');card.setAttribute('data-label',item?item.label:(source.key==='photoset'?'SET ':'SRC ')+String(i+1).padStart(2,'0'));if(item){var img=document.createElement('img');img.src=item.url;img.alt=item.name||('Referenz '+(i+1));card.appendChild(img);var cap=document.createElement('div');cap.className='matrix-caption';cap.textContent=item.name||item.label;card.appendChild(cap);}else{card.textContent='AWAITING INPUT';}grid.appendChild(card)};var title=$('#wait-reference-title'), kicker=$('#wait-reference-kicker'), mode=$('#wait-reference-mode'), hint=$('#wait-reference-hint');if(title)title.textContent=source.title;if(kicker)kicker.textContent=App.waitKind==='scenes'?'ACTIVE SCENE REFERENCE':'REFERENCE SOURCE';if(mode)mode.textContent=source.chip;if(hint)hint.textContent=source.hint;}
  function cycleWaitReferences(){var sources=waitReferenceSources();if(sources.length<2)return;App.waitReferenceSourceIndex=(App.waitReferenceSourceIndex+1)%sources.length;renderWaitReferences();}
  function renderWaitExtendedVisuals(){var source=waitReferenceSources()[0],items=source&&source.items?source.items:[];var forge=$('#wait-forge-sources');if(forge){forge.innerHTML='';for(var i=0;i<4;i++){var box=document.createElement('div');box.className='forge-source';if(items[i]){var img=document.createElement('img');img.src=items[i].url;img.alt='';box.appendChild(img)}forge.appendChild(box)}}var shard=$('#wait-shard-stage');if(shard){var shards=shard.querySelectorAll('.shard');Array.prototype.forEach.call(shards,function(el,i){el.style.backgroundImage=items[i]?'url("'+String(items[i].url).replace(/"/g,'%22')+'")':'none';});}}
  function renderWaitSlots(){var grid=$('#wait-slot-grid');if(!grid)return;grid.innerHTML='';var labels=App.waitKind==='scenes'?['SCENE 01','SCENE 02','SCENE 03']:['SET 01','SET 02','SET 03','SET 04'];labels.forEach(function(label,i){var slot=document.createElement('div');slot.className='wait-slot';slot.innerHTML='<em>ENCRYPTED SLOT</em><strong>'+label+'</strong><span>BUILDING</span>';grid.appendChild(slot)});}
  function pushTerminalLine(textValue){var wrap=$('#terminal-lines');if(!wrap)return;var line=document.createElement('div');line.textContent='> '+new Date().toLocaleTimeString('de-DE')+'  '+textValue;wrap.appendChild(line);while(wrap.children.length>12)wrap.removeChild(wrap.firstChild);wrap.scrollTop=wrap.scrollHeight;}
  function startWait(kind){
    var configs={photoset:{kicker:'IDENTITY ENGINE',title:'FotoSet wird synthetisiert',status:'IDENTITY SYNTHESIS ACTIVE'},scenes:{kicker:'SCENE ENGINE',title:'3 Szenen werden parallel erzeugt',status:'SCENE SYNTHESIS ACTIVE'}};
    var c=configs[kind]||configs.photoset, msgs=waitMessages(kind), mi=0;
    App.waitKind=kind;var views=waitViews();
    App.waitViewIndex=0; $('#wait-kicker').textContent=c.kicker; $('#wait-title').textContent=c.title; $('#wait-message').textContent=msgs[0]; $('#wait-status-line').textContent=c.status; $('#terminal-lines').innerHTML=''; $('#wait-elapsed').textContent='Elapsed 00:00';
    App.waitReferenceSourceIndex=0; renderWaitReferences(0); renderWaitSlots(); renderWaitExtendedVisuals(); setWaitView(views[0]);
    var layer=$('#wait-layer'); layer.classList.add('open'); layer.setAttribute('aria-hidden','false');
    clearInterval(App.progressTimer); clearInterval(App.terminalTimer); clearInterval(App.waitViewTimer); clearInterval(App.waitElapsedTimer); clearInterval(App.waitReferenceTimer);
    pushTerminalLine('loading reference matrix ............ OK');
    pushTerminalLine(kind==='scenes'?'parallel scene pipeline ............. ACTIVE':'identity reconstruction ............ ACTIVE');
    App.terminalTimer=setInterval(function(){mi=(mi+1)%msgs.length; $('#wait-message').textContent=msgs[mi]; var scripted=[
      'mapping facial landmarks ............ 128 nodes',
      'calculating identity vectors ........ RUNNING',
      'preserving facial proportions ....... ACTIVE',
      'matching hair geometry .............. LOCKED',
      'matching skin characteristics ....... LOCKED',
      kind==='scenes'?'constructing scene prompt ........... ACTIVE':'constructing variant '+String((mi%4)+1).padStart(2,'0')+' ............. READY',
      kind==='scenes'?'local scene storage ................. SYNC':'photoset card storage ............... SYNC'
    ]; pushTerminalLine(scripted[mi%scripted.length]);}, 3200);
    App.waitViewTimer=setInterval(rotateWaitView, kind==='photoset'?16000:26000);
    if(waitReferenceSources().length>1) App.waitReferenceTimer=setInterval(cycleWaitReferences, 9000);
    var start=Date.now();
    App.waitElapsedTimer=setInterval(function(){var elapsed=Math.floor((Date.now()-start)/1000),m=Math.floor(elapsed/60),s=elapsed%60; $('#wait-elapsed').textContent='Elapsed '+String(m).padStart(2,'0')+':'+String(s).padStart(2,'0');},1000);
  }
  function stopWait(){clearInterval(App.progressTimer);clearInterval(App.terminalTimer);clearInterval(App.waitViewTimer);clearInterval(App.waitElapsedTimer);clearInterval(App.waitReferenceTimer);setTimeout(function(){$('#wait-layer').classList.remove('open');$('#wait-layer').setAttribute('aria-hidden','true')},220)}

  function finishWaitWithDecrypt(kind,done){
    App.waitKind=kind;setWaitView('matrix');var slots=$$('#wait-slot-grid .wait-slot');slots.forEach(function(slot,i){var status=slot.querySelector('span');if(status)status.textContent='DECRYPTING';slot.classList.add('slot-decrypting');setTimeout(function(){slot.classList.add('slot-ready');if(status)status.textContent='READY';},180+i*140);});pushTerminalLine('generation complete .................. OK');pushTerminalLine('decrypting result payload ............ ACTIVE');setTimeout(function(){stopWait();setTimeout(done,260);},720);
  }
  function pollPhotoSet(){
    api('poll_photoset',{strict:false}).then(function(r){if(r.ok&&r.status==='succeeded'){App.state=r.state;var libraryRefresh=refreshSavedPhotoSets(false);finishWaitWithDecrypt('photoset',function(){renderPhotoSet(App.state.photoset_images||r.images,true);renderPhotoSetHistory();gotoStep(2)});libraryRefresh.then(function(result){if(!result.ok)toast('Die neue FotoSetCard ist verfügbar, aber das dauerhafte Archiv konnte nicht aktualisiert werden.')})}else if(r.status==='succeeded_storage_failed'){stopWait();if(r.state)App.state=r.state;toast(r.message||'Das FotoSet konnte nicht gespeichert werden.','SPEICHERN WIEDERHOLEN',function(){startWait('photoset');pollPhotoSet()})}else if(r.ok){setTimeout(pollPhotoSet,1800)}else{stopWait();toast(r.message||'FotoSet-Generierung fehlgeschlagen.')}}).catch(function(e){stopWait();toast(e.message)});
  }
  function pollScenes(){
    api('poll_scenes',{strict:false}).then(function(r){if(r.ok&&r.status==='succeeded'){App.state=r.state;finishWaitWithDecrypt('scenes',function(){renderFinal(App.state.scene_results||r.results,true);gotoStep(6)})}else if(r.ok){setTimeout(pollScenes,1800)}else{stopWait();toast(r.message||'Szenengenerierung fehlgeschlagen.')}}).catch(function(e){stopWait();toast(e.message)});
  }

  function bind(){
    var zone=$('#drop-zone'),input=$('#photo-input');zone.onclick=function(){App.replaceIndex=null;input.multiple=true;input.click()};['dragenter','dragover'].forEach(function(ev){zone.addEventListener(ev,function(e){e.preventDefault();zone.classList.add('drag')})});['dragleave','drop'].forEach(function(ev){zone.addEventListener(ev,function(e){e.preventDefault();zone.classList.remove('drag')})});zone.addEventListener('drop',function(e){uploadFiles(e.dataTransfer.files,null)});input.addEventListener('change',function(){uploadFiles(input.files,App.replaceIndex);input.value='';input.multiple=true;App.replaceIndex=null});
    $('#generate-photoset').onclick=function(){startWait('photoset');api('start_photoset',{method:'POST'}).then(function(){pollPhotoSet()}).catch(function(e){stopWait();toast(e.message)})};
    $('#open-saved-photosets').onclick=function(){var grid=$('#photoset-library-grid');if(grid)grid.innerHTML='<div class="photoset-library-loading">Storage wird gelesen …</div>';refreshSavedPhotoSets(true)};$('#photoset-library-backdrop').onclick=closeSavedPhotoSets;$('#photoset-library-x').onclick=closeSavedPhotoSets;
    $('#reject-photoset').onclick=function(){api('restart_photoset',{method:'POST'}).then(function(r){App.state=r.state;gotoStep(1);renderUploads();renderPhotoSetHistory()}).catch(function(e){toast(e.message)})};
    $('#approve-photoset').onclick=function(){startWait('photoset');$('#wait-title').textContent='FotoSet wird gespeichert';$('#wait-message').textContent='Freigegebene Bilder werden als Referenzsatz zwischengespeichert …';api('approve_photoset',{method:'POST'}).then(function(r){stopWait();App.state=r.state;renderPhotoSetHistory();gotoStep(3)}).catch(function(e){stopWait();toast(e.message)})};
    $('#photoset-prev').onclick=function(){selectPhotoSetOffset(-1)};
    $('#photoset-next').onclick=function(){selectPhotoSetOffset(1)};
    $('#open-photoset-history').onclick=function(){var attempts=photosetAttempts();if(!attempts.length)return;var idx=activeAttemptIndex();if(idx<0)idx=attempts.length-1;selectPhotoSetAttempt(attempts[idx].id)};
    var photosetNav=document.querySelector('[data-step-nav="2"]');if(photosetNav)photosetNav.onclick=function(){var attempts=photosetAttempts();if(!attempts.length)return;var idx=activeAttemptIndex();if(idx<0)idx=attempts.length-1;selectPhotoSetAttempt(attempts[idx].id)};
    $('#profile-form').addEventListener('submit',function(e){e.preventDefault();var fd=new FormData(e.currentTarget);api('save_profile',{method:'POST',body:fd}).then(function(r){App.state=r.state;gotoStep(4)}).catch(function(e2){toast(e2.message)})});
    $('#location').addEventListener('change',toggleRegion);
    $('#location-form').addEventListener('submit',function(e){e.preventDefault();var fd=new FormData(e.currentTarget);api('save_location',{method:'POST',body:fd}).then(function(r){App.state=r.state;renderScenes(r.scenes);gotoStep(5)}).catch(function(e2){toast(e2.message)})});
    $('#scenes-form').addEventListener('submit',function(e){e.preventDefault();var selected=$$('#scene-options input:checked');if(selected.length!==3)return;var fd=new FormData();selected.forEach(function(x){fd.append('scenes[]',x.value)});api('save_scenes',{method:'POST',body:fd}).then(function(r){App.state=r.state;startWait('scenes');return api('start_scenes',{method:'POST'})}).then(function(){pollScenes()}).catch(function(e2){stopWait();toast(e2.message)})});
    $('#restart-all').onclick=function(){api('reset_all',{method:'POST'}).then(function(){location.reload()}).catch(function(e){toast(e.message)})};$('#back-scenes').onclick=function(){gotoStep(5)};
    $('#gallery-close').onclick=closeGallery;$('#gallery-x').onclick=closeGallery;$('#gallery-prev').onclick=function(){shiftGallery(-1)};$('#gallery-next').onclick=function(){shiftGallery(1)};$$('[data-wait-view]').forEach(function(btn){btn.onclick=function(){setWaitView(btn.getAttribute('data-wait-view'))}});document.addEventListener('keydown',function(e){if($('#photoset-library-modal').classList.contains('open')){if(e.key==='Escape')closeSavedPhotoSets();return}if($('#gallery-modal').classList.contains('open')){if(e.key==='Escape')closeGallery();else if(e.key==='ArrowLeft')shiftGallery(-1);else if(e.key==='ArrowRight')shiftGallery(1);return}if($('#wait-layer').classList.contains('open')){if(e.key==='1'){setWaitView('references')}else if(e.key==='2'){setWaitView('identity')}else if(e.key==='3'){setWaitView('matrix')}else if(e.key==='4'){setWaitView('terminal')}else if(e.key==='ArrowLeft'){shiftWaitView(-1)}else if(e.key==='ArrowRight'){shiftWaitView(1)}}});
  }
  function uploadFiles(files,replaceId){if(!files||!files.length)return;var before=(App.state&&App.state.uploads||[]).map(function(u){return u.id}),button=$('#generate-photoset'),original=button.textContent;App.uploading=true;button.disabled=true;button.textContent='Upload läuft …';var fd=new FormData();Array.prototype.forEach.call(files,function(f){fd.append('photos[]',f)});if(replaceId!==null&&replaceId!==undefined)fd.append('replace_upload_id',replaceId);api('upload',{method:'POST',body:fd}).then(function(r){var uploads=r.state.uploads||[],changed=uploads.filter(function(u){return before.indexOf(u.id)<0}).map(function(u){return u.id});App.state=r.state;App.uploading=false;renderUploads(changed,replaceId!==null&&replaceId!==undefined?'replace':'upload',replaceId);renderPhotoSetHistory();renderWaitReferences()}).catch(function(e){App.uploading=false;markUploadError();toast(e.message)}).finally(function(){button.textContent=original;button.disabled=!(App.state&&App.state.uploads&&App.state.uploads.length)})}

  function matrix(canvas,opacityMode){
    var ctx=canvas.getContext('2d'),font=opacityMode?14:12,drops=[],cols=0,chars='01ABCDEFGHIJKLMNOPQRSTUVWXYZアイウエオカキクケコサシスセソ';function resize(){var dpr=Math.min(window.devicePixelRatio||1,2);canvas.width=innerWidth*dpr;canvas.height=innerHeight*dpr;canvas.style.width=innerWidth+'px';canvas.style.height=innerHeight+'px';ctx.setTransform(dpr,0,0,dpr,0,0);cols=Math.ceil(innerWidth/font);drops=[];for(var i=0;i<cols;i++)drops[i]=Math.random()*-80}function draw(){ctx.fillStyle=opacityMode?'rgba(0,5,2,.10)':'rgba(2,7,4,.12)';ctx.fillRect(0,0,innerWidth,innerHeight);ctx.font=font+'px ui-monospace, monospace';ctx.fillStyle=opacityMode?'rgba(85,255,136,.6)':'rgba(85,255,136,.45)';for(var i=0;i<drops.length;i++){var ch=chars.charAt(Math.floor(Math.random()*chars.length));ctx.fillText(ch,i*font,drops[i]*font);if(drops[i]*font>innerHeight&&Math.random()>.975)drops[i]=0;drops[i]+=.42+Math.random()*.5}requestAnimationFrame(draw)}resize();window.addEventListener('resize',resize);draw()}

  document.addEventListener('DOMContentLoaded',function(){document.addEventListener('keydown',function(){App.lastInputWasKeyboard=true},true);document.addEventListener('pointerdown',function(){App.lastInputWasKeyboard=false},true);matrix($('#matrix-bg'),false);matrix($('#wait-matrix'),true);bind();refreshSavedPhotoSets(false);api('bootstrap').then(configureUi).catch(function(e){$('#system-label').textContent='CONFIG REQUIRED';toast(e.message);api('status').then(function(r){App.state=r.state;renderUploads();renderPhotoSetHistory();gotoStep(1)}).catch(function(){})})});
})();
