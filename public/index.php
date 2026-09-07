<?php
require_once dirname(__DIR__) . '/app/bootstrap.php';
if (!headers_sent()) {
    header('Content-Type: text/html; charset=UTF-8');
    header('Cache-Control: no-store, no-cache, must-revalidate');
}
?><!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>Photo Matrix // Scene Workflow</title>
    <link rel="stylesheet" href="assets/app.css?v=<?php echo (int)@filemtime(__DIR__ . '/assets/app.css'); ?>">
</head>
<body>
<canvas id="matrix-bg" aria-hidden="true"></canvas>
<div class="noise" aria-hidden="true"></div>

<main class="shell">
    <header class="topbar">
        <div class="brand">
            <span class="brand-mark">M</span>
            <div>
                <strong>PHOTO MATRIX</strong>
                <small>IDENTITY → SCENE SYNTHESIS</small>
            </div>
        </div>
        <div class="system-state"><span class="pulse"></span><span id="system-label">SYSTEM READY</span></div>
    </header>

    <nav class="stepper" aria-label="Workflow">
        <button type="button" data-step-nav="1"><b>01</b><span>Fotos</span></button>
        <i></i><button type="button" data-step-nav="2"><b>02</b><span>FotoSet</span></button>
        <i></i><button type="button" data-step-nav="3"><b>03</b><span>Look</span></button>
        <i></i><button type="button" data-step-nav="4"><b>04</b><span>Location</span></button>
        <i></i><button type="button" data-step-nav="5"><b>05</b><span>Szenen</span></button>
        <i></i><button type="button" data-step-nav="6"><b>06</b><span>Resultat</span></button>
    </nav>

    <section class="stage active" data-step="1">
        <div class="eyebrow">INPUT NODE // 01</div>
        <h1>Referenzfotos laden</h1>
        <p class="lead">1–4 Bilder hochladen. Gute Referenzen zeigen Gesicht und Erscheinungsbild klar und ohne starke Verdeckung.</p>

        <div class="upload-zone" id="drop-zone">
            <input id="photo-input" type="file" accept="image/jpeg,image/png,image/webp" multiple hidden>
            <div class="upload-icon">＋</div>
            <strong>Bilder hier ablegen</strong>
            <span>oder klicken · JPEG / PNG / WEBP · max. 4 Dateien</span>
        </div>
        <div id="upload-grid" class="image-grid upload-grid"></div>

        <div class="existing-photoset-choice">
            <div class="existing-photoset-divider"><span>ODER</span></div>
            <button class="existing-photoset-button" id="open-saved-photosets" type="button">
                <span class="existing-photoset-icon">▦</span>
                <span>
                    <small>FOTOSET ARCHIV</small>
                    <strong>Bestehendes FotoSet wählen</strong>
                    <em id="saved-photoset-count">Gespeicherte FotoSets laden</em>
                </span>
                <b>→</b>
            </button>
        </div>

        <div id="photoset-history-shortcut" class="history-shortcut hidden">
            <div><small>ZWISCHENSPEICHER</small><strong id="photoset-history-count">0 FotoSetCards gespeichert</strong></div>
            <button class="btn ghost" id="open-photoset-history" type="button">Gespeicherte Versuche ansehen →</button>
        </div>
        <div class="actions right">
            <button class="btn primary" id="generate-photoset" type="button">FotoSet generieren <span>→</span></button>
        </div>
    </section>

    <section class="stage" data-step="2">
        <div class="eyebrow">IDENTITY SYNTHESIS // 02</div>
        <h1>Passt dieses FotoSet?</h1>
        <p class="lead">Prüfe Identität, Gesicht, Haare und Gesamterscheinung. Bei Abweichungen kannst du einzelne Ausgangsfotos ersetzen und neu generieren. Jeder erfolgreiche Versuch wird als FotoSetCard zwischengespeichert.</p>

        <div id="photoset-browser" class="photoset-browser hidden">
            <button class="history-arrow" id="photoset-prev" type="button" aria-label="Vorheriges FotoSet">←</button>
            <div class="history-browser-label">
                <small>FOTOSET CARD ARCHIVE</small>
                <strong id="photoset-position">Versuch 1 von 1</strong>
                <span id="photoset-created"></span>
            </div>
            <button class="history-arrow" id="photoset-next" type="button" aria-label="Nächstes FotoSet">→</button>
        </div>
        <div id="photoset-history" class="photoset-history"></div>
        <div id="photoset-grid" class="image-grid result-grid"></div>
        <div class="decision-panel">
            <div><small>STATUS</small><strong>FotoSet bereit zur Freigabe</strong></div>
            <div class="actions">
                <button class="btn ghost" id="reject-photoset" type="button">Nein, korrigieren</button>
                <button class="btn primary" id="approve-photoset" type="button">Ja, FotoSet verwenden <span>→</span></button>
            </div>
        </div>
    </section>

    <section class="stage" data-step="3">
        <div class="eyebrow">PERSON PROFILE // 03</div>
        <h1>Person & Bildsprache</h1>
        <p class="lead">Diese Angaben werden zusammen mit dem freigegebenen FotoSet an die Szenengenerierung übergeben.</p>
        <form id="profile-form" class="form-grid" autocomplete="off">
            <label class="field">
                <span>Größe in cm</span>
                <input name="height" id="height" type="number" min="100" max="230" step="1" placeholder="z. B. 182" required>
            </label>
            <label class="field">
                <span>Mann oder Frau</span>
                <select name="gender" id="gender" required></select>
            </label>
            <label class="field full">
                <span>Stil der Kleidung</span>
                <select name="clothing" id="clothing" required></select>
            </label>
            <label class="field full">
                <span>Bildstil</span>
                <select name="image_style" id="image-style" required></select>
            </label>
            <div class="actions full right"><button class="btn primary" type="submit">Location wählen <span>→</span></button></div>
        </form>
    </section>

    <section class="stage" data-step="4">
        <div class="eyebrow">LOCATION MATRIX // 04</div>
        <h1>Wo findet das Shooting statt?</h1>
        <p class="lead">Die Location-Kategorie steuert, welche Szenengruppe im nächsten Schritt angeboten wird.</p>
        <form id="location-form" class="form-grid" autocomplete="off">
            <label class="field full">
                <span>Location-Kategorie</span>
                <select name="location" id="location" required></select>
            </label>
            <label class="field full hidden" id="region-wrap">
                <span>Region für Außenaufnahmen</span>
                <select name="region" id="region"></select>
            </label>
            <div class="category-hint full" id="category-hint">Szenenfilter wird nach Auswahl automatisch aktiviert.</div>
            <div class="actions full right"><button class="btn primary" type="submit">Szenen auswählen <span>→</span></button></div>
        </form>
    </section>

    <section class="stage" data-step="5">
        <div class="eyebrow">SCENE SELECTOR // 05</div>
        <h1>Genau 3 Szenen auswählen</h1>
        <p class="lead">Es werden nur Szenen aus der zur Location passenden Gruppe angeboten: A Außen · B Büro · C Zuhause beim Kunden · D Im Objekt · E Erweitert.</p>
        <form id="scenes-form">
            <div id="scene-options" class="scene-grid"></div>
            <div class="selection-meter"><span id="scene-count">0 / 3 gewählt</span><i><b id="scene-meter"></b></i></div>
            <div class="actions right"><button class="btn primary" id="start-scenes" type="submit" disabled>3 Szenen generieren <span>→</span></button></div>
        </form>
    </section>

    <section class="stage" data-step="6">
        <div class="eyebrow">OUTPUT NODE // 06</div>
        <h1>Deine drei Szenen</h1>
        <p class="lead">Die drei Bilder wurden mit denselben Personen- und Stilparametern, aber unterschiedlichen Szenen erzeugt.</p>
        <div id="final-grid" class="image-grid final-grid"></div>
        <div class="actions split">
            <button class="btn ghost" id="restart-all" type="button">Neuen Durchlauf starten</button>
            <button class="btn primary" id="back-scenes" type="button">Andere Szenen wählen</button>
        </div>
    </section>

    <footer><span>BKI WORKFLOW</span><span>PROJECT 23 → PROJECT 18</span><span>ASYNC RUN ENGINE</span></footer>
</main>

<div class="wait-layer" id="wait-layer" aria-hidden="true">
    <canvas id="wait-matrix"></canvas>
    <div class="wait-card cinematic">
        <div class="wait-head">
            <div>
                <div class="wait-kicker" id="wait-kicker">PROCESSING</div>
                <h2 id="wait-title">Daten werden verarbeitet</h2>
                <p id="wait-message">Verbindung zum Generierungsdienst wird aufgebaut …</p>
            </div>
            <div class="orb"><span></span><span></span><span></span></div>
        </div>

        <div class="wait-toolbar">
            <div class="wait-tabs" id="wait-tabs">
                <button type="button" class="wait-tab active" data-wait-view="references">REFERENCES</button>
                <button type="button" class="wait-tab" data-wait-view="identity">IDENTITY</button>
                <button type="button" class="wait-tab" data-wait-view="matrix">MATRIX</button>
                <button type="button" class="wait-tab" data-wait-view="terminal">TERMINAL</button>
            </div>
            <div class="wait-toolbar-meta"><div class="wait-auto-meta" id="wait-auto-meta">AUTO 01 / 14</div><div class="wait-chip" id="wait-visual-note">VISUAL PROCESS REPRESENTATION</div></div>
        </div>

        <div class="wait-visuals">
            <section class="wait-view active" data-view="references">
                <div class="reference-strip">
                    <div>
                        <small id="wait-reference-kicker">REFERENCE SOURCE</small>
                        <strong id="wait-reference-title">Hochgeladene Referenzbilder</strong>
                    </div>
                    <div class="wait-chip small" id="wait-reference-mode">SOURCE INPUT</div>
                </div>
                <div class="reference-flow">
                    <div class="reference-grid" id="wait-reference-grid"></div>
                    <div class="reference-core">
                        <div class="core-ring"></div>
                        <div class="core-ring inner"></div>
                        <div class="core-label">IDENTITY CORE</div>
                        <div class="scan-line"></div>
                    </div>
                </div>
                <div class="reference-hint" id="wait-reference-hint">Referenzbilder werden gescannt, analysiert und zu einem konsistenten Identitätskern zusammengeführt.</div>
            </section>

            <section class="wait-view" data-view="identity">
                <div class="identity-stage">
                    <div class="identity-grid"></div>
                    <div class="identity-head">
                        <div class="head-outline"></div>
                        <div class="head-outline second"></div>
                        <span class="node n1"></span><span class="node n2"></span><span class="node n3"></span><span class="node n4"></span><span class="node n5"></span><span class="node n6"></span>
                        <div class="scanner"></div>
                    </div>
                    <div class="identity-tags">
                        <span>EYES // LOCK</span>
                        <span>FACE GEOMETRY</span>
                        <span>HAIR PROFILE</span>
                        <span>IDENTITY VECTOR</span>
                    </div>
                </div>
            </section>

            <section class="wait-view" data-view="matrix">
                <div class="network-stage">
                    <div class="network-grid">
                        <i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i>
                    </div>
                    <div class="network-lines">
                        <span class="l1"></span><span class="l2"></span><span class="l3"></span><span class="l4"></span><span class="l5"></span><span class="l6"></span><span class="l7"></span><span class="l8"></span>
                    </div>
                    <div class="slot-grid" id="wait-slot-grid"></div>
                </div>
            </section>

            <section class="wait-view" data-view="biometric">
                <div class="module-head"><small>BIOMETRIC RADAR // 05</small><strong>Merkmalsräume werden abgeglichen</strong></div>
                <div class="radar-stage"><div class="radar-ring r1"></div><div class="radar-ring r2"></div><div class="radar-ring r3"></div><div class="radar-cross x"></div><div class="radar-cross y"></div><div class="radar-sweep"></div><i class="radar-dot d1"></i><i class="radar-dot d2"></i><i class="radar-dot d3"></i><i class="radar-dot d4"></i><span class="radar-label a">FACIAL</span><span class="radar-label b">PROFILE</span><span class="radar-label c">BODY</span><span class="radar-label d">STYLE</span></div>
            </section>

            <section class="wait-view" data-view="helix">
                <div class="module-head"><small>IDENTITY HELIX // 06</small><strong>Visuelle Signaturen werden synchronisiert</strong></div>
                <div class="helix-stage" aria-hidden="true"><div class="helix-column h1"></div><div class="helix-column h2"></div><div class="helix-bridges"><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i></div></div>
                <div class="helix-stats"><span>FACE SIGNATURE <b>LOCKED</b></span><span>BODY RATIO <b>SYNC</b></span><span>PROFILE VECTOR <b>ACTIVE</b></span></div>
            </section>

            <section class="wait-view" data-view="landmarks">
                <div class="module-head"><small>LANDMARK CONSTELLATION // 07</small><strong>Gesichtsgeometrie wird stabilisiert</strong></div>
                <div class="landmark-stage"><div class="landmark-face"></div><div class="landmark-lines"></div><i class="lm l1"></i><i class="lm l2"></i><i class="lm l3"></i><i class="lm l4"></i><i class="lm l5"></i><i class="lm l6"></i><i class="lm l7"></i><i class="lm l8"></i><i class="lm l9"></i><div class="landmark-wave"></div></div>
            </section>

            <section class="wait-view" data-view="forge">
                <div class="module-head"><small>PIXEL FORGE // 08</small><strong>Referenzen werden in Varianten überführt</strong></div>
                <div class="forge-stage"><div class="forge-sources" id="wait-forge-sources"></div><div class="forge-arrow"><span>→</span><i></i><i></i><i></i></div><div class="forge-cube"><b></b><b></b><b></b><span>SYNTHESIS</span></div></div>
            </section>

            <section class="wait-view" data-view="vector">
                <div class="module-head"><small>VECTOR LOCK // 09</small><strong>Identitätsvektoren werden ausgerichtet</strong></div>
                <div class="vector-stage"><div class="vector-axis horizontal"></div><div class="vector-axis vertical"></div><div class="vector-orbit o1"></div><div class="vector-orbit o2"></div><div class="vector-arrow v1"></div><div class="vector-arrow v2"></div><div class="vector-arrow v3"></div><div class="vector-lock">LOCK</div></div>
            </section>

            <section class="wait-view" data-view="memory">
                <div class="module-head"><small>MEMORY LATTICE // 10</small><strong>Referenzmerkmale werden konsolidiert</strong></div>
                <div class="memory-stage"><div class="memory-column c1"></div><div class="memory-column c2"></div><div class="memory-column c3"></div><div class="memory-column c4"></div><div class="memory-column c5"></div><div class="memory-core">IDENTITY<br>MEMORY</div></div>
            </section>

            <section class="wait-view" data-view="entropy">
                <div class="module-head"><small>ENTROPY FILTER // 11</small><strong>Störsignale werden herausgefiltert</strong></div>
                <div class="entropy-stage"><div class="entropy-noise"></div><div class="entropy-gate"><span>FILTER</span></div><div class="entropy-clean"><i></i><i></i><i></i><i></i><i></i><i></i></div></div>
                <div class="entropy-copy">REFERENCE NOISE → FEATURE ISOLATION → CONSISTENT SIGNAL</div>
            </section>

            <section class="wait-view" data-view="shards">
                <div class="module-head"><small>IDENTITY SHARDS // 12</small><strong>Teilansichten werden rekombiniert</strong></div>
                <div class="shard-stage" id="wait-shard-stage"><div class="shard s1"></div><div class="shard s2"></div><div class="shard s3"></div><div class="shard s4"></div><div class="shard-center">RECOMBINE</div></div>
            </section>

            <section class="wait-view" data-view="checksum">
                <div class="module-head"><small>CONSISTENCY CHECKSUM // 13</small><strong>Merkmale werden gegen Referenzen geprüft</strong></div>
                <div class="checksum-stage"><div class="checksum-code"><span>FACE_HASH</span><b>8F 1A C3 77 9B 04</b><span>BODY_HASH</span><b>24 E9 A1 5D C0 31</b><span>STYLE_HASH</span><b>71 88 FE 02 A4 C9</b></div><div class="checksum-ring"><strong>PASS</strong><span>CONSISTENCY</span></div></div>
            </section>

            <section class="wait-view" data-view="vault">
                <div class="module-head"><small>SYNTHESIS VAULT // 14</small><strong>FotoSetCard wird für die Ausgabe versiegelt</strong></div>
                <div class="vault-stage"><div class="vault-door"><div class="vault-ring vr1"></div><div class="vault-ring vr2"></div><div class="vault-spokes"><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i></div><div class="vault-center">SET CARD</div></div><div class="vault-status"><span>VARIANT 01</span><b>QUEUED</b><span>VARIANT 02</span><b>QUEUED</b><span>VARIANT 03</span><b>QUEUED</b><span>VARIANT 04</span><b>QUEUED</b></div></div>
            </section>

            <section class="wait-view terminal-view" data-view="terminal">
                <div class="terminal-label">VISUAL PROCESS REPRESENTATION</div>
                <div class="terminal terminal-large" id="terminal-lines"></div>
            </section>
            <div class="wait-page-dots" id="wait-page-dots" aria-hidden="true"></div>
        </div>

        <div class="activity-track" aria-hidden="true">
            <b></b><b></b><b></b><b></b><b></b><b></b><b></b><b></b><b></b><b></b><b></b><b></b>
        </div>
        <div class="wait-meta detailed"><span id="wait-elapsed">Elapsed 00:00</span><span id="wait-status-line">IDENTITY SYNTHESIS ACTIVE</span><span>DO NOT CLOSE THIS WINDOW</span></div>
    </div>
</div>


<div class="photoset-library-modal" id="photoset-library-modal" aria-hidden="true">
    <div class="photoset-library-backdrop" id="photoset-library-backdrop"></div>
    <div class="photoset-library-panel" role="dialog" aria-modal="true" aria-label="Gespeicherte FotoSets">
        <div class="photoset-library-head">
            <div>
                <small>FOTOSET ARCHIVE // STORAGE</small>
                <h2>Bestehendes FotoSet wählen</h2>
                <p>Gespeicherte FotoSetCards können direkt wiederverwendet werden. Nach der Auswahl kannst du das Set noch einmal prüfen und freigeben.</p>
            </div>
            <button class="gallery-x" id="photoset-library-x" type="button" aria-label="FotoSet-Archiv schließen">×</button>
        </div>
        <div id="photoset-library-grid" class="photoset-library-grid">
            <div class="photoset-library-loading">Storage wird gelesen …</div>
        </div>
    </div>
</div>

<div class="gallery-modal" id="gallery-modal" aria-hidden="true">
    <div class="gallery-backdrop" id="gallery-close"></div>
    <div class="gallery-panel" role="dialog" aria-modal="true" aria-label="Szenen-Galerie">
        <button class="gallery-x" id="gallery-x" type="button" aria-label="Galerie schließen">×</button>
        <button class="gallery-nav prev" id="gallery-prev" type="button" aria-label="Vorheriges Bild">←</button>
        <figure class="gallery-figure">
            <img id="gallery-image" alt="Szenenbild">
            <figcaption>
                <small>SCENE GALLERY</small>
                <strong id="gallery-title">Szene</strong>
                <span id="gallery-meta"></span>
            </figcaption>
        </figure>
        <button class="gallery-nav next" id="gallery-next" type="button" aria-label="Nächstes Bild">→</button>
        <div class="gallery-thumbs" id="gallery-thumbs"></div>
    </div>
</div>

<div class="toast" id="toast"></div>
<script src="assets/app.js?v=<?php echo (int)@filemtime(__DIR__ . '/assets/app.js'); ?>" charset="utf-8"></script>
</body>
</html>
