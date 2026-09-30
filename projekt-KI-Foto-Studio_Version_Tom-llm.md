# BKI-Projektintegration: KI-Foto-Studio Version Tom

> **Vertrauliche, eigenständige Integrationsdatei.** Diese Datei enthält den persönlichen BKI-Zugang, die allgemeinen API-Regeln und den vollständigen Vertrag dieses Projekts. Es wird keine weitere `llm.md` benötigt.
> Verwende den API-Key ausschließlich serverseitig. Schreibe ihn niemals in Browser-JavaScript, HTML, mobile Apps, öffentliche Repositories, Antworten, Protokolle oder Fehlermeldungen.

## 1. Was macht dieses Projekt?

Erstellt professionelle KI-Fotoshootings mit vielseitigen Innen- und Außenaufnahmen.

- Projekt-ID: `18`
- Aktiver Projektstand: `7.9.3`
- Zweck für einen Chatbot: Erfrage oder übernimm die unten beschriebenen Eingaben, validiere sie über die BKI API und starte anschließend einen Projektlauf.

## 2. Eingabemöglichkeiten

### Größe in cm angeben

- API-Schlüssel in `values`: `2879`
- Typ: Kurzer Text (`text`)
- Pflichtfeld: ja

### Geschlecht

- API-Schlüssel in `values`: `2880`
- Typ: Einzelauswahl (`radio`)
- Pflichtfeld: ja
- Zulässige Werte (genau die Bezeichnung senden):
  - `Mann`
  - `Frau`

### Kleidung

- API-Schlüssel in `values`: `2881`
- Typ: Einzelauswahl (`select`)
- Pflichtfeld: ja
- Zulässige Werte (genau die Bezeichnung senden):
  - `Business Formal - Mann` → Promptwert: `### 5.1. Business Formal #### 5.1.1. Allgemein: Die Kleidung auf den Referenzbildern ist nicht relevant, entscheidend ist die folgende Kleidung: Die Maklerperson trägt Kleidung im Stil „Business Formal“. Der Look ist sehr formell, konservativ, hochwertig und repräsentativ, mit klarer Silhouette, perfekter Passform und dunklen seriösen Farben. Casual-Elemente, auffällige Muster, sichtbare Logos und modische Übertreibungen werden vermieden. #### 5.1.2. Mann: Die männliche Maklerperson trägt einen perfekt sitzenden dunklen Anzug in Navy, Anthrazit oder Dunkelgrau mit weißem oder hellblauem Businesshemd. Eine schlichte Krawatte ist optional. Dazu passen polierte Lederschuhe in Schwarz oder Dunkelbraun. Accessoires bleiben minimal; keine Sneaker, Jeans, Poloshirts, T-Shirts oder auffälligen Einstecktücher.`
  - `Business Professional - Mann` → Promptwert: `### 5.1. Business Professional #### 5.1.1. Allgemein: Die Kleidung auf den Referenzbildern ist nicht relevant, entscheidend ist die folgende Kleidung: Die Maklerperson trägt Kleidung im Stil „Business Professional“. Der Look ist klassisch, seriös und für Bürotermine sowie Kundengespräche geeignet. Die Kleidung wirkt gepflegt, hochwertig und vertrauenswürdig, dabei jedoch weniger streng und formell als klassische Business-Formal-Kleidung. #### 5.1.2. Mann: Die männliche Maklerperson trägt entweder ein Sakko mit Hemd und Stoffhose oder einen vollständigen Anzug mit Hemd, jeweils kombiniert mit gepflegten Lederschuhen. Die Kleidung besteht aus hochwertigen, fein strukturierten Stoffen. Bevorzugte Farben sind gedeckte und harmonisch aufeinander abgestimmte Töne wie Navy, Grau, Beige, Weiß und Hellblau.`
  - `Business Casual - Mann` → Promptwert: `### 5.1. Business Casual #### 5.1.1. Allgemein: Die Kleidung auf den Referenzbildern ist nicht relevant, entscheidend ist die folgende Kleidung: Die Maklerperson trägt Kleidung im Stil „Business Casual“. Der Look ist modern, gepflegt, professionell und zugänglich, ohne steif zu wirken. Die Kleidungsstücke sind hochwertig und bürotauglich. Stark ausgewaschene Jeans, Sportkleidung, große Schriftzüge, sichtbare Logos und ungepflegte Schuhe werden vermieden. #### 5.1.2. Mann: Die männliche Maklerperson trägt Premium-Strick, Rollkragen oder ein hochwertiges Hemd ohne Krawatte, optional mit unstrukturiertem Sakko oder Cardigan. Dazu passen Chino, Stoffhose oder dunkle einfarbige Jeans sowie Loafer, Lederschuhe oder minimalistische Sneaker. Die Farben sind überwiegend neutral, ergänzt durch dezentes Oliv oder Schiefergrün.`
  - `Smart Casual - Mann` → Promptwert: `### 5.1. Smart Casual #### 5.1.1. Allgemein: Die Kleidung auf den Referenzbildern ist nicht relevant, entscheidend ist die folgende Kleidung: Die Maklerperson trägt Kleidung im Stil „Smart Casual“. Der Look ist gepflegt, modern, natürlich, zugänglich, nicht steif, aber trotzdem professionell und für Bürotermine sowie Kundengespräche geeignet. Die Kleidung wirkt gepflegt, hochwertig und vertrauenswürdig, aber deutlich weniger streng und formell als klassische Business-Kleidung. #### 5.1.2. Mann: Die männliche Maklerperson trägt ein modernes unstrukturiertes Sakko mit Rollkragen, Polo, Hemd ohne Krawatte oder hochwertigem einfarbigem T-Shirt. Dazu passen dunkle Jeans, Stoffhose oder Chino sowie Loafer, Lederschuhe oder minimalistische Sneaker. Kein Einstecktuch. Bevorzugte Farben sind gedeckte und harmonisch aufeinander abgestimmte Töne wie Grau, Beige, Weiß, Navy und Hellblau, kombiniert mit einem Akzent wie Burgunder, Oliv, Schiefergrün oder hellem Gelb.`
  - `Corporate / Branded - Mann` → Promptwert: `### 5.1. Corporate / Branded #### 5.1.1. Allgemein: Die Kleidung auf den Referenzbildern ist nicht relevant, entscheidend ist die folgende Kleidung: Die Maklerperson trägt Kleidung im Stil „Corporate / Branded“. Der Look ist einheitlich, sauber, serviceorientiert und dezent an die Unternehmensidentität angepasst. Der Hexadezimalcode definiert die Referenzfarbe; harmonische Abstufungen sind erlaubt. Das Logo wird unverändert aus „LOGO“ übernommen und klein auf der linken Brust platziert. Zusätzliche Symbole, erfundene Schrift und werbliche Überladung werden vermieden. #### 5.1.2. Mann: Die männliche Maklerperson trägt Poloshirt oder Hemd in der Referenzfarbe oder einer harmonischen Abstufung, optional mit Softshelljacke, Weste, Cardigan oder schlichtem Sakko. Dazu passen Chino oder Stoffhose in neutralen Farben sowie Lederschuhe, Loafer oder minimalistische Sneaker. Das Logo bleibt klein und proportional; keine Zusatztexte oder konkurrierenden Farben.`
  - `Creative Professional - Mann` → Promptwert: `### 5.1. Creative Professional #### 5.1.1. Allgemein: Die Kleidung auf den Referenzbildern ist nicht relevant, entscheidend ist die folgende Kleidung: Die Maklerperson trägt Kleidung im Stil „Creative Professional“. Der Look verbindet einen modernen Business-Auftritt mit einer kreativen Note und wirkt individuell, charakterstark und professionell. Kreativität entsteht durch besondere Schnitte, Materialkombinationen oder einen gezielten Farbakzent. Große Logos, laute Schriftzüge und kostümhafte Details werden vermieden. #### 5.1.2. Mann: Die männliche Maklerperson trägt ein modernes, unstrukturiertes oder markant geschnittenes Sakko mit T-Shirt, Rollkragen, Hemd oder elegantem Overshirt. Dazu passen Stoffhose, Chino oder dunkle Jeans sowie Derbys, Loafer, Chelsea Boots oder minimalistische Sneaker. Akzente in Petrol, Oliv, Burgunder oder Terrakotta sind möglich. Keine Krawatte, kein Einstecktuch und keine überladene Streetwear.`
  - `Tech Casual - Mann` → Promptwert: `### 5.1. Tech Casual #### 5.1.1. Allgemein: Die Kleidung auf den Referenzbildern ist nicht relevant, entscheidend ist die folgende Kleidung: Die Maklerperson trägt Kleidung im Stil „Tech Casual“. Der Look ist minimalistisch, modern, funktional und unkompliziert und vermittelt Innovationsnähe. Klare Linien, praktische Schichten und neutrale Farben bestimmen den Stil. Sportkleidung, Loungewear, Gamer-Merchandising, große Logos, Neonfarben und stark abgenutzte Kleidung werden vermieden. #### 5.1.2. Mann: Die männliche Maklerperson trägt ein einfarbiges T-Shirt, einen schlichten Hoodie ohne Aufdruck, Sweatshirt, Feinstrick oder Overshirt, optional mit leichter technischer Jacke. Dazu passen dunkle Jeans, Chino oder Stoffhose sowie gepflegte minimalistische Sneaker. Bevorzugt werden Schwarz, Grau, Navy, Weiß und dunkles Oliv. Keine Gaming-Motive, Jogginghosen oder sichtbare Sportausrüstung.`
  - `Privat - Mann` → Promptwert: `### 5.1. Privat #### 5.1.1. Allgemein: Die Kleidung auf den Referenzbildern ist nicht relevant, entscheidend ist die folgende Kleidung: Die Maklerperson trägt Kleidung im Stil „Privat“. Der Look ist gepflegt, natürlich, altersgerecht und für soziale Netzwerke, persönliche Websites oder informelle Profilseiten geeignet. Er wirkt authentisch und nicht geschäftlich, aber auch nicht nachlässig. Harmonische Farben, bequeme moderne Passform und zurückhaltende Individualität sind erwünscht; große Logos und beschädigte Kleidung werden vermieden. #### 5.1.2. Mann: Die männliche Maklerperson trägt Langarmshirt, Poloshirt, Freizeithemd, Feinstrickpullover, Strickjacke oder leichtes Overshirt. Dazu passen gepflegte Jeans, Chino oder Stoffhose sowie saubere Sneaker, Loafer oder Alltagsschuhe. Ruhige Farben und ein dezentes persönliches Detail schaffen natürliche Eleganz. Keine Krawatte, Jogginghose, großen Logos oder deutlich geschäftlichen Corporate-Elemente.`
  - `wie Referenzfoto ohne Bildauswahl` → Promptwert: `### 5.1. Übernahme der Kleidung aus einem Referenzfoto * orientiere dich genau an der Kleidung der Maklerperson auf dem gewählten Referenzfoto. * Übernehme Schnitt, Stil und Zusammenstellung der Kleidung * Die Kleidung darf leicht hochwertiger wirken, muss aber natürlich und zur Person passend bleiben. * Natürliche Tragespuren und leichte Bewegungsfalten`
  - `Business Formal - Frau` → Promptwert: `### 5.1. Business Professional #### 5.1.1. Allgemein: Die Kleidung auf den Referenzbildern ist nicht relevant, entscheidend ist die folgende Kleidung: Die Maklerperson trägt Kleidung im Stil „Business Professional“. Der Look ist klassisch, seriös und für Bürotermine sowie Kundengespräche geeignet. Die Kleidung wirkt gepflegt, hochwertig und vertrauenswürdig, dabei jedoch weniger streng und formell als klassische Business-Formal-Kleidung. #### 5.1.2 Frau: Die weibliche Maklerperson trägt Blazer, entweder zusammen mit Stoffhose oder mit Rock oder Kleid oder Etuikleid; dazu Bluse, Feinstrick oder hochwertiges Top. Hochwertige, fein strukturierte Stoffe. Bevorzugte Farben sind gedeckte und harmonisch aufeinander abgestimmte Töne.`
  - `Business Professional - Frau` → Promptwert: `### 5.1. Business Professional #### 5.1.1. Allgemein: Die Kleidung auf den Referenzbildern ist nicht relevant, entscheidend ist die folgende Kleidung: Die Maklerperson trägt Kleidung im Stil „Business Professional“. Der Look ist klassisch, seriös und für Bürotermine sowie Kundengespräche geeignet. Die Kleidung wirkt gepflegt, hochwertig und vertrauenswürdig, dabei jedoch weniger streng und formell als klassische Business-Formal-Kleidung. #### 5.1.2. Frau: Blazer mit Stoffhose, Rock, Kleid oder Etuikleid; Bluse, Feinstrick oder hochwertiges Top; feine Stoffe, dezente Farben.`
  - `Business Casual - Frau` → Promptwert: `### 5.1. Business Casual #### 5.1.1. Allgemein: Die Kleidung auf den Referenzbildern ist nicht relevant, entscheidend ist die folgende Kleidung: Die Maklerperson trägt Kleidung im Stil „Business Casual“. Der Look ist modern, gepflegt, professionell und zugänglich, ohne steif zu wirken. Die Kleidungsstücke sind hochwertig und bürotauglich. Stark ausgewaschene Jeans, Sportkleidung, große Schriftzüge, sichtbare Logos und ungepflegte Schuhe werden vermieden. #### 5.1.3. Frau: Die weibliche Maklerperson trägt Blazer, Cardigan oder hochwertige Strickjacke mit Premium-Strick, Rollkragen, Bluse oder geschlossenem Top. Dazu passen Stoffhose, Chino, Rock oder dunkle gepflegte Jeans sowie Loafer, flache Schuhe, niedrige Pumps oder minimalistische Sneaker. Sportelemente, beschädigte Jeans und große Logos werden vermieden.`
  - `Smart Casual - Frau` → Promptwert: `### 5.1. Smart Casual #### 5.1.1. Allgemein: Die Kleidung auf den Referenzbildern ist nicht relevant, entscheidend ist die folgende Kleidung: Die Maklerperson trägt Kleidung im Stil „Smart Casual“. Der Look ist gepflegt, modern, natürlich, zugänglich, nicht steif, aber trotzdem professionell und für Bürotermine sowie Kundengespräche geeignet. Die Kleidung wirkt gepflegt, hochwertig und vertrauenswürdig, aber deutlich weniger streng und formell als klassische Business-Kleidung. #### 5.1.2 Frau: Die weibliche Maklerperson trägt einen modernen Blazer oder eine klar geschnittene Jacke mit Top, Bluse, Feinstrick oder Rollkragen. Dazu passen Stoffhose, weiter Schnitt, Rock, schlichtes Kleid oder dunkle Jeans. Geeignet sind Loafer, Slingbacks, Stiefeletten oder Schuhe mit flachem Absatz. Neutrale Farben werden mit einem kontrollierten modernen Akzent kombiniert.`
  - `Corporate / Branded - Frau` → Promptwert: `### 5.1. Corporate / Branded #### 5.1.1. Allgemein: Die Kleidung auf den Referenzbildern ist nicht relevant, entscheidend ist die folgende Kleidung: Die Maklerperson trägt Kleidung im Stil „Corporate / Branded“. Der Look ist einheitlich, sauber, serviceorientiert und dezent an die Unternehmensidentität angepasst. Der Hexadezimalcode definiert die Referenzfarbe; harmonische Abstufungen sind erlaubt. Das Logo wird unverändert aus „LOGO“ übernommen und klein auf der linken Brust platziert. Zusätzliche Symbole, erfundene Schrift und werbliche Überladung werden vermieden. #### 5.1.3. Frau: Die weibliche Maklerperson trägt Bluse oder Poloshirt in der Referenzfarbe oder einer harmonischen Abstufung, optional mit Blazer, Cardigan, Weste oder Softshelljacke. Dazu passen Stoffhose, Chino oder schlichter Rock sowie Loafer, flache Lederschuhe, Pumps oder minimalistische Sneaker. Das Logo bleibt klein und unverändert; zusätzliche Werbung oder erfundene Texte sind ausgeschlossen.`
  - `Creative Professional - Frau` → Promptwert: `### 5.1. Creative Professional #### 5.1.1. Allgemein: Die Kleidung auf den Referenzbildern ist nicht relevant, entscheidend ist die folgende Kleidung: Die Maklerperson trägt Kleidung im Stil „Creative Professional“. Der Look verbindet einen modernen Business-Auftritt mit einer kreativen Note und wirkt individuell, charakterstark und professionell. Kreativität entsteht durch besondere Schnitte, Materialkombinationen oder einen gezielten Farbakzent. Große Logos, laute Schriftzüge und kostümhafte Details werden vermieden. #### 5.1.3. Frau: Die weibliche Maklerperson trägt einen besonders geschnittenen Blazer oder eine strukturierte Jacke mit besonderer Bluse, Top, Feinstrick oder Rollkragen. Dazu passen weite Stoffhose, Midi-Rock, hochwertiges Kleid oder dunkle Jeans. Stoffstruktur, dezente Asymmetrie oder ein kontrollierter Farbakzent sind erwünscht. Überladene Muster und kostümhafte Extravaganz werden vermieden.`
  - `Tech Casual - Frau` → Promptwert: `### 5.1. Tech Casual #### 5.1.1. Allgemein: Die Kleidung auf den Referenzbildern ist nicht relevant, entscheidend ist die folgende Kleidung: Die Maklerperson trägt Kleidung im Stil „Tech Casual“. Der Look ist minimalistisch, modern, funktional und unkompliziert und vermittelt Innovationsnähe. Klare Linien, praktische Schichten und neutrale Farben bestimmen den Stil. Sportkleidung, Loungewear, Gamer-Merchandising, große Logos, Neonfarben und stark abgenutzte Kleidung werden vermieden. #### 5.1.3. Frau: Die weibliche Maklerperson trägt ein einfarbiges T-Shirt, einen schlichten Hoodie ohne Aufdruck, Sweatshirt, Feinstrick, Cardigan oder Overshirt, optional mit leichter technischer Jacke. Dazu passen dunkle Jeans, Chino, Stoffhose oder schlichter Rock sowie minimalistische Sneaker, Loafer oder flache Schuhe. Große Logos, Neonfarben und reine Athleisure-Optik werden vermieden.`
  - `Privat - Frau` → Promptwert: `### 5.1. Privat #### 5.1.1. Allgemein: Die Kleidung auf den Referenzbildern ist nicht relevant, entscheidend ist die folgende Kleidung: Die Maklerperson trägt Kleidung im Stil „Privat“. Der Look ist gepflegt, natürlich, altersgerecht und für soziale Netzwerke, persönliche Websites oder informelle Profilseiten geeignet. Er wirkt authentisch und nicht geschäftlich, aber auch nicht nachlässig. Harmonische Farben, bequeme moderne Passform und zurückhaltende Individualität sind erwünscht; große Logos und beschädigte Kleidung werden vermieden. #### 5.1.3. Frau: Die weibliche Maklerperson trägt Langarmshirt, Bluse, Feinstrickpullover, Cardigan, Strickjacke oder leichtes Overshirt. Dazu passen gepflegte Jeans, Stoffhose, Chino oder schlichter Rock sowie Sneaker, Loafer, flache Schuhe, Stiefeletten oder dezente Sandalen. Harmonische Farben und ein persönliches Detail wirken authentisch. Formelle Hosenanzüge, reine Loungewear, große Logos und starke Corporate-Anmutung werden vermieden.`

### Bildstil

- API-Schlüssel in `values`: `2882`
- Typ: Einzelauswahl (`select`)
- Pflichtfeld: ja
- Zulässige Werte (genau die Bezeichnung senden):
  - `Corporate` → Promptwert: `Corporate Ruhige, professionelle und hochwertige Corporate-Bildsprache mit neutraler, seriöser Wirkung. Natürliche Hauttöne, moderate Kontraste, dezentes Toning, sauberer Weißabgleich und zurückhaltende Retusche. Die Farben wirken lebendig, klar und natürlich gesättigt. Keine grellen, übersättigten oder künstlich verstärkten Farbtöne.`
  - `Lifestyle-/Reportage` → Promptwert: `Lifestyle und Reportage Spontane, bewegte und nahbare Bildsprache mit glaubwürdig ungestellter Wirkung. Natürliches Umgebungslicht. Warme Farben und moderate Kontraste. Die Retusche bleibt minimal; kleine Unperfektheiten. Situative Momente dürfen sichtbar bleiben.`
  - `Editorial` → Promptwert: `Editorial Inszenierte, charakterstarke Bildsprache mit magazinartiger und bewusst stilisierter Wirkung. Prägnante Farben, starke Kontraste und gerichtetes Licht erzeugen eine eigenständige visuelle Handschrift. Die Retusche ist sichtbar ausgearbeitet und unterstützt einen klar definierten Look. Ungewöhnliche Perspektiven.`
  - `Environmental` → Promptwert: `Environmental Bildausschnitt: weite Totale. Personen sind vom Kopf bis zu den Füßen sichtbar. Personen und Umfeld tragen gleichwertig zur Aussage bei. Die Umgebung bleibt klar lesbar. Das Hauptmotiv erscheint weit weg. Viel Fläche für den Anschnitt des Bildes in allen Richtungen, viel Copyspace. Die Beleuchtung der zentralen Szene und die der Umgebung sind organisch und glaubwürdig verbunden.`
  - `Highkey` → Promptwert: `Highkey Sehr helle, luftige und reduzierte Bildsprache mit offener, positiver Wirkung. Gamma-Wert auf 2.3 erhöhen. Weiche Ausleuchtung, geringe Kontraste und saubere Weißflächen erzeugen Leichtigkeit und Transparenz. Schatten, Glanzstellen und störende Farbstiche werden konsequent minimiert.`
  - `Schwarz-Weiß` → Promptwert: `Schwarz-Weiß Schwarz-Weiß-Foto. Monochrome, konzentrierte, markante Bildsprache mit souveräner und zeitloser Wirkung. Mittelhelle Hintergründe. Präzise Grauabstufungen, gerichtetes Licht und klare Tonwerttrennung modellieren Gesicht und Ausdruck. Dodge and Burn sowie selektive Schärfung verstärken Präsenz und Struktur. Ausschließlich Grautöne im finalen Bild.`
  - `Corporate-Tech` → Promptwert: `Corporate-Tech Kühle, futuristische Bildsprache mit digitaler und visionärer Wirkung. Teal- und Cyan-Töne, warme Lichtakzente, Glasreflexionen und geringe Tiefenschärfe prägen den Look. Bloom, Kantenlicht und glattes Compositing erzeugen ein hochwertiges technologisches Finish.`

### Location-Kategorie

- API-Schlüssel in `values`: `2883`
- Typ: Einzelauswahl (`select`)
- Pflichtfeld: ja
- Zulässige Werte (genau die Bezeichnung senden):
  - `Außen` → Promptwert: `Außen #### 7.2.1. Belichtung Ausschließlich natürlich aussehendes Umgebungslicht, ohne sichtbaren Blitz, Studiolicht oder sichtbares künstliches Aufhelllicht. #### 7.2.2. Look und Lichtstimmung * Helles, freundliches Tageslicht eines schönen Frühsommertags im Mai oder Juni. Tageszeit: später Vormittag oder früher Nachmittag. Die Sonne steht ausreichend hoch. * Sehr wenig direkte Sonne, keine goldene Stunde, kein tief stehendes warmes Sonnenlicht und keine künstlich dramatische Lichtstimmung. Kein graues Wetter, keine herbstliche oder düstere Atmosphäre und keine Unterbelichtung. * Die Vegetation wirkt lebendig und frisch, mit grünem Laub, blühenden Pflanzen und gepflegten Hecken. Keine verblühten Pflanzen, keine kahlen Sträucher und keine trocken und ungepflegt wirkende Vegetation. * Im Hintergrund können sehr vereinzelt sanfte, diffuse Sonnenflecken auf Hauswänden, Mauern, Zaun, Blüten oder Vegetation sichtbar sein, wie durch Laub oder leichte Wolken gefiltertes Sonnenlicht. Diese Lichtakzente wirken weich, dezent und leicht warm, bleiben jedoch klar untergeordnet und dürfen nicht zum Hauptmotiv werden. Sie erzeugen lediglich einen subtilen Hauch von sommerlicher Wärme im Hintergrund, während die Maklerperson weiterhin natürlich und der Szene entsprechend beleuchtet bleibt. Die Richtung des Sonnenlichts wirkt sich auf die Eigenschatten der Maklerperson aus. Keine dramatische Lichtwirkung.`
  - `Büro` → Promptwert: `Büro #### 7.2.1. Belichtung * Ausschließlich durch Fenster einfallendes Tageslicht und dessen diffuses Umgebungslicht; keine künstliche Beleuchtung oder Aufhellung. * Vorhandene Innenraumleuchten sind ausgeschaltet und visuell unauffällig. Sie erscheinen weder direkt noch in Glas- oder Fensterreflexionen heller als die umgebenden Deckenflächen und zeigen keinerlei Leuchtwirkung. #### 7.2.2. Look und Lichtstimmung * Helles, freundliches Tageslicht scheint als weiches, eher diffuses Fensterlicht in den Raum. Das Licht ist gleichmäßig und schafft eine offene, ruhige und vertrauensbildende Atmosphäre. * Sehr wenig direkte Sonne, keine harten Lichtstrahlen, keine überbelichteten Fenster, keine goldene Stunde, kein tief stehendes warmes Licht, keine dramatische Stimmung und keine Unterbelichtung. * Mittelgroßes, helles, modernes und hochwertiges, seriöses, realistisches und gepflegtes Immobilienmaklerbüro in Deutschland. Neutrale, hochwertige Büromöbel, dezente Farben und realistische Gestaltung. Nicht luxuriös über-inszeniert. Kein Showroom. * Im Hintergrund dürfen Schreibtische, Regale, Pflanzen, Besprechungsbereiche sowie markenfreie, nicht lesbare Unterlagen, Grundrisse oder Exposés erscheinen. Aufgeräumt und belebt, aber nicht überladen. Anmutung klassischer Bestandsimmobilien; keine dominante Neubau-, Bauträger- oder Baustellenästhetik. Keine Architekturmodelle als Hauptmotiv. * Hintergrund minimal unscharf mit sehr dezenter Bokeh-Wirkung, die Raumstruktur bleibt erkennbar. Dezente, leicht warme Farbakzente entstehen ausschließlich durch Materialien und Möbel. Lichtführung und Schatten werden ausschließlich vom Fenster-Tageslicht erzeugt.`
  - `Zuhause beim Kunden` → Promptwert: `Zuhause beim Kunden #### 7.2.1. Belichtung Ausschließlich natürlich aussehendes, durch Fenster einfallendes Tageslicht und davon erzeugtes weiches Umgebungslicht, ohne sichtbaren Blitz, Studiolicht oder sichtbares künstliches Aufhelllicht. Vorhandene Wohnraumleuchten bleiben ausgeschaltet oder wirken höchstens sehr dezent und verursachen keine auffälligen Farbstiche. #### 7.2.2. Look und Lichtstimmung * Helles, freundliches Tageslicht fällt weich durch ein oder mehrere Fenster in den Wohnraum. Die Beleuchtung wirkt natürlich, gleichmäßig und leicht warm. * Keine harte direkte Sonne, keine ausgeprägten Lichtstrahlen, keine goldene Stunde, keine dramatische Lichtstimmung und keine Unterbelichtung. Draußen ist ein heller, freundlicher Tag erkennbar. * Helles, gepflegtes und glaubwürdig bewohntes Wohnzimmer eines privaten Haushalts in Deutschland. Die Einrichtung wirkt modern, wohnlich und hochwertig, nicht inszeniert wie im Möbelhaus, Showroom oder Ferienapartment. * Im Raum dürfen Sofa, Sessel, Regale, Bücher, Pflanzen, Vorhänge, dezente Wandbilder und nicht identifizierbare Wohnaccessoires erscheinen. Aufgeräumt und einladend, dezent dekoriert. * Der Hintergrund bleibt als tatsächlicher Wohnraum erkennbar und ist nur leicht unscharf. Warme Holz- und Naturtöne unterstützen dezent die gemütliche, vertrauensvolle Atmosphäre. Lichtführung und Eigenschatten sind plausibel; die Personen sind glaubwürdig in den Raum eingebunden.`
  - `Im Objekt` → Promptwert: `Im Objekt #### 7.2.1. Belichtung Ausschließlich natürlich aussehendes, durch Fenster einfallendes Tageslicht und davon erzeugtes diffuses Umgebungslicht, ohne sichtbaren Blitz, Studiolicht oder sichtbares künstliches Aufhelllicht. Das Licht verteilt sich realistisch im Raum und erhält Zeichnung in hellen Fensterflächen und schattigen Raumbereichen. #### 7.2.2. Look und Lichtstimmung * Helles, neutrales bis leicht warmes Tageslicht fällt durch ausreichend große Fenster in das Objekt. Die Räume wirken freundlich, klar und realistisch, mit weichen Schatten und natürlicher Helligkeitsabstufung. * Keine harte direkte Sonne, keine ausgeprägten Lichtkegel, keine überbelichteten Fenster, keine goldene Stunde, keine dramatische Lichtstimmung. * Gepflegtes, leer stehendes oder weitgehend unmöbliertes Immobilienobjekt in Deutschland. Solider, zeitgemäß modernisierter Bestandsbau; kein historischer Altbau, keine Baustelle und keine dominante Neubau-, Musterhaus- oder Bauträgerästhetik. * Helle, neutrale Wände, neutraler Boden sowie normale Fenster, Türen und Raumproportionen. Keine luxuriöse Überinszenierung, keine auffälligen Designermaterialien und keine unrealistisch großen, vollständig verglasten Räume. * Die Raumstruktur bleibt gut lesbar und bildet einen glaubwürdigen Kontext für Besichtigung, Begutachtung oder Prüfung. Sehr dezente Tiefenunschärfe ist möglich, ohne relevante Gebäudedetails aufzulösen. Linien, Perspektive, Lichtrichtung und Eigenschatten wirken architektonisch plausibel.`
  - `Erweitert/Sonstige` → Promptwert: `Erweitert/Sonstige #### 7.2.1. Belichtung Professionelle, kontrollierte und natürlich wirkende Ausleuchtung entsprechend der konkreten Szenenbeschreibung. Weiches Hauptlicht und eine sehr dezente Aufhellung sind zulässig. Keine sichtbare Lichtquelle, kein Blitz und kein Studioequipment sichtbar. Natürliche Farben. #### 7.2.2. Look und Lichtstimmung * Professioneller Vollformatkamera-Look * Helle, klare und ausgewogene Lichtwirkung mit natürlichen Hauttönen, weichen Schatten und sauberer Zeichnung im Gesicht und in der Kleidung. * Keine dramatische oder stark kontrastreiche Lichtstimmung, sofern sie nicht ausdrücklich durch das Motiv vorgegeben ist. * Der Hintergrund richtet sich unbedingt nach der Szenenbeschreibung. * Bei Freistellern bleiben Konturen, Haare und Kleidung vollständig erhalten. Die Person wirkt nicht ausgeschnitten oder künstlich aufgeklebt. * Keine übertriebene Retusche, keine porzellanartige Haut, keine unnatürlichen Lichtkanten, kein starker Bloom und kein übermäßiges Bokeh. * Logos, Schrift und grafische Elemente erscheinen nur, wenn die Szenenbeschreibung sie ausdrücklich vorsieht.`

### Region

- API-Schlüssel in `values`: `2884`
- Typ: Einzelauswahl (`select`)
- Pflichtfeld: nein
- Zulässige Werte (genau die Bezeichnung senden):
  - `1. Küstennahe Kleinstadt` → Promptwert: `### 7.3. Regionale Zuordnung: Küstennahe Kleinstadt Die Szene spielt in einer hellen, windgeprägten Kleinstadt nahe der norddeutschen oder ostdeutschen Küste. Alle sichtbaren Gebäude, Außenbereiche und Gestaltungselemente müssen glaubwürdig zur küstennahen Region und zum kleinstädtischen Maßstab passen. Dezentes maritimes Flair darf nur indirekt über Architektur, Materialien, Wetterwirkung und einzelne zurückhaltende Details entstehen. Kein offenes Wasser, kein Meer. * **Architektur und Umfeld:** Helle, saubere Kleinstadtumgebung mit weitem Himmel, niedriger bis mittelhoher Bebauung und einem ruhigen, gepflegten Straßenbild. Typisch sind Klinkerhäuser, verputzte Wohnhäuser mit Ziegeldächern, schlichte Giebel, vereinzelt Reet- oder Pfannendächer sowie dezente maritime Hinweise wie wetterfeste Fensterläden, Hausnummernschilder, Tauelemente oder zurückhaltende blau-weiße Akzente. Die Szene wirkt windoffen, norddeutsch und eindeutig kleinstädtisch. * **Materialien und Grundstücksgestaltung:** Regional plausible Materialien wie roter oder dunkel gebrannter Klinker, Backstein, heller Putz, Dachziegel, Naturholz und verzinktes oder dunkel beschichtetes Metall. Vorgärten und Eingangsbereiche sind ordentlich, robust und wetterbeständig gestaltet, beispielsweise mit Kiesstreifen, Klinkerpflaster, Betonstein oder einfachen Natursteinplatten. Die Gestaltung wirkt bodenständig, dauerhaft und regional zurückhaltend. * **Einfriedungen – sofern sichtbar:** Hüfthoher weißer Holz- oder Friesenzaun, alternativ ein niedriger dunkler Metallzaun, eine geschnittene Hecke oder eine schlichte Kombination daraus. Die konkrete Ausführung richtet sich nach Haustyp, Grundstück und Straßenlage. Einfriedungen dürfen leicht wind- und wettergeprägt wirken, bleiben jedoch gepflegt und sind kein zwingender Bestandteil des Bildes, sofern sie nicht von der konkreten Szene ausdrücklich verlangt werden. * **Vegetation:** Die sichtbaren Vorgärten, Gärten und Grünflächen zeigen eine für die norddeutsche Küstenregion und die beschriebene Jahreszeit glaubwürdige, windverträgliche Bepflanzung. Geeignet sind robuste Hecken, Gräser, niedrige Stauden, Rosen, Hortensien, Sanddorn, einzelne kleinwüchsige Laubbäume und kompakte Sträucher. Die Vegetation wirkt vom Wind leicht bewegt, natürlich gewachsen und regional plausibel.`
  - `2. Backstein-Wohnstraße` → Promptwert: `### 7.3. Regionale Zuordnung: Backstein-Wohnstraße Die Szene spielt in einer typischen norddeutschen oder niederrheinischen Wohnstraße, deren Bild von roten Backsteinfassaden, kleinen Vorgärten und einer ruhigen, gewachsenen Nachbarschaft geprägt wird. Alle sichtbaren Gebäude, Grundstücke und Gestaltungselemente müssen glaubwürdig zur deutschen Backsteintradition und zum jeweiligen Baualter passen. * **Architektur und Umfeld:** Ruhige Wohnstraße mit freistehenden Häusern, Doppelhäusern oder kleinen Reihenhausgruppen aus unterschiedlichen Bauphasen. Prägend sind rote bis dunkelrote Backsteinfassaden, einfache Sattel- oder Walmdächer, weiße oder dunkle Fensterrahmen, gelegentliche Erker und zurückhaltende Hauseingänge. Kleine Vorgärten, Hecken und schmale Zufahrten erzeugen eine gepflegte, alltägliche Wohnatmosphäre. * **Materialien und Grundstücksgestaltung:** Sichtbarer Backstein oder Klinker bildet das wichtigste Fassadenmaterial und kann mit hellem Putz, Dachziegeln, Betonstein, Naturholz und dunklem Metall kombiniert werden. Gehwege, Einfahrten und Hauszugänge bestehen plausibel aus Klinkerpflaster, Betonstein oder schlichten Platten. Grundstücke wirken individuell weiterentwickelt und zeigen leichte Unterschiede bei Pflaster, Briefkästen, Mülltonnenplätzen und Bepflanzung. * **Einfriedungen – sofern sichtbar:** Niedriger Klinkersockel oder Kombinationen aus Klinkerpfeilern und Metallfeldern vor einem gepflegten Vorgarten. Auch ein niedriger dunkler Metallzaun, weißer Friesenzaun, schlichter Holzzaun oder eine geschnittene Hecke sind regional plausibel. Die Einfriedung bleibt niedrig, transparent und zur Architektur passend; sie ist kein zwingender Bestandteil des Bildes, sofern sie nicht ausdrücklich verlangt wird. * **Vegetation:** Die sichtbaren Grünflächen und Pflanzbereiche zeigen eine für Niederrhein und Norddeutschland und die beschriebene Jahreszeit glaubwürdige und sparsame Bepflanzung. Typisch sind grüne Hecken, Rasenflächen, robuste Stauden, Rosen, Hortensien und einzelne klein- bis mittelkronige Laubbäume. Die Vorgärten wirken gepflegt, natürlich und individuell. Regionale, wind- und niederschlagsverträgliche Pflanzen bestimmen das Bild.`
  - `3. Flachland – ländlicher Ortsrand` → Promptwert: `### 7.3. Regionale Zuordnung: Flachland – ländlicher Ortsrand Die Szene spielt an einem ruhigen ländlichen Ortsrand im ost- oder norddeutschen Flachland mit freistehendem Wohnhaus und weitem Blick über Felder, Wiesen und einzelne Baumreihen. Alle sichtbaren Gebäude und Elemente müssen glaubwürdig zur offenen ost- oder norddeutschen Kulturlandschaft passen. * **Architektur und Umfeld:** Locker bebauter Ortsrand mit einem freistehenden Einfamilienhaus, einem ehemaligen Bauernhaus oder einem schlichten Wohngebäude und wenigen benachbarten Gebäuden. Hinter oder neben dem Grundstück öffnet sich der Blick in flache Felder, Wiesen, Weiden und einzelne Baum- oder Heckenreihen. Die Straße ist ruhig, eher schmal und funktional; die Szene wirkt ländlich, alltagstauglich und typisch für das norddeutsche Flachland. * **Materialien und Grundstücksgestaltung:** Regional plausible Kombinationen aus Backstein, Klinker, hellem Putz, roten oder dunklen Dachziegeln, Holz und einfachen Beton- oder Natursteinbelägen. Zufahrten, Nebengebäude und Grundstücksränder dürfen praktisch und leicht landwirtschaftlich geprägt sein. Die Gestaltung wirkt gepflegt, aber weniger formal als in einer Vorstadt; kleine Nutzflächen, Geräteschuppen oder zurückhaltende Wirtschaftsdetails sind möglich. * **Einfriedungen – sofern sichtbar:** Hüfthoher Lattenzaun aus Holz, schlichter Weidezaun, niedriger Metallzaun oder eine natürliche Hecke. Auch regional typische Wallhecken- oder Knickstrukturen können am Übergang zur Landschaft angedeutet werden. Einfriedungen wirken natürlich, unaufdringlich und funktional; sie sind kein zwingender Bestandteil des Bildes, sofern sie nicht von der konkreten Szene verlangt werden. * **Vegetation:** Die sichtbaren Grünflächen und Pflanzbereiche zeigen eine für das norddeutsche Flachland und die beschriebene Jahreszeit glaubwürdige Bepflanzung. Wiesen, Rasenflächen, heimische Hecken und einzelne Baumreihen prägen die Vegetation: Eichen, Weiden, Erlen, Hainbuchen, Hasel, Schlehen, Holunder und robuste Obstbäume. Die Bepflanzung wirkt weitläufig, windbewegt und landschaftlich eingebunden.`
  - `4. Einkaufsstraße in historischer Altstadt` → Promptwert: `### 7.3. Regionale Zuordnung: Einkaufsstraße in historischer Hansestadt Die Szene spielt in einer belebten Einkaufsstraße einer historischen norddeutschen Altstadt. Alle sichtbaren Fassaden, Schaufenster, Straßenräume und Gestaltungselemente müssen glaubwürdig zur gewachsenen Altstadtstruktur einer norddeutschen Mittelstadt oder größeren Hansestadt passen. * **Architektur und Umfeld:** Dicht gefasste Einkaufsstraße mit historischen Altbaufassaden, schmalen Parzellen, Giebelhäusern, Backstein- oder Putzfassaden und Erdgeschosszonen mit Schaufenstern. Pflaster oder ein breiter Gehweg, dezente Außengastronomie, Passanten und Straßenbäume schaffen eine lebendige, aber geordnete Innenstadtatmosphäre. Einzelne Fassaden dürfen hanseatische, klassizistische oder gründerzeitliche Merkmale zeigen. * **Materialien und Grundstücksgestaltung:** Typisch sind Backstein, Klinker, heller oder farbig zurückhaltender Putz, Naturstein- oder Ziegelsockel, Holz- und Metallrahmen sowie Pflaster aus Naturstein, Klinker oder hochwertigem Betonstein. Schaufenster, Markisen und Beschilderungen sind in Größe und Gestaltung an die historische Gebäudestruktur angepasst. Moderne Einbauten dürfen sichtbar sein, müssen sich jedoch unaufdringlich in den Bestand einfügen. * **Einfriedungen – sofern sichtbar:** Historisch wirkender schwarzer Metallzaun oder steinerne Begrenzungsmauer vor einem Eingangsbereich oder Platzrand. In der eigentlichen Einkaufszone sind Einfriedungen eher selten und nur dort plausibel, wo Gebäude zurückgesetzt stehen oder ein kleiner Hof, Kirchplatz oder Grünbereich angrenzt. Die konkrete Ausführung richtet sich nach der jeweiligen Altstadtsituation. * **Vegetation:** Die wenigen sichtbaren Grünflächen und Pflanzbereiche zeigen eine für eine norddeutsche Altstadt und die beschriebene Jahreszeit glaubwürdige Bepflanzung. Straßenbäume, Pflanzkübel und kleine bepflanzte Platzränder zeigen eine robuste, stadtverträgliche und jahreszeitlich glaubwürdige Vegetation. Die Vegetation ergänzt die Architektur und lässt Schaufenster, Giebel und Straßenraum klar erkennbar.`
  - `5. Großstadt – Altbaustraße` → Promptwert: `### 7.3. Regionale Zuordnung: Großstadt – Altbaustraße Die Szene spielt in einer urbanen deutschen Großstadtstraße mit sanierten Gründerzeit- und Altbaufassaden. Alle sichtbaren Gebäude, Vorgärten, Straßenräume und Details müssen glaubwürdig zu einem gewachsenen großstädtischen Quartier in Deutschland passen. * **Architektur und Umfeld:** Mehrgeschossige Altbauten mit sanierten Gründerzeitfassaden, hohen Fenstern, Balkonen, Erkern und klar gegliederten Hauseingängen. Straßenbäume, schmale Vorgärten oder Souterrainbereiche und unscharf im Hintergrund parkende Autos erzeugen eine urbane, bewohnte Atmosphäre. Die Straße wirkt dicht, gepflegt, alltäglich und als gewachsener Altbaubestand erkennbar. * **Materialien und Grundstücksgestaltung:** Heller oder gedeckter Fassadenputz, sichtbarer Backstein oder Klinker, Natursteinsockel, Stuckelemente, Holz- oder Metallfenster und dunkle Balkongeländer sind plausibel. Gehwege bestehen aus Betonplatten, Naturstein oder kleinteiligem Pflaster; Hauseingänge und Souterrainzugänge können mit Stufen, Lichtschächten und schmalen Vorgartenstreifen ausgebildet sein. Sanierungen wirken hochwertig und zeigen zugleich die Individualität der einzelnen Gebäude. * **Einfriedungen – sofern sichtbar:** Naturstein- oder Klinkersockel mit schlichten senkrechten Metallstäben und zurückhaltenden Zierelementen. Möglich ist ein historischer schwarzer Metallzaun vor einem kleinen Vorgarten, Souterrainbereich oder zurückgesetzten Hauseingang. Die Einfriedung folgt der Fassadengliederung und bleibt transparent; bei direkt am Gehweg stehenden Gebäuden kann sie vollständig entfallen. * **Vegetation:** Die sichtbaren Grünflächen und Pflanzbereiche zeigen eine für ein deutsches Großstadtquartier und die beschriebene Jahreszeit glaubwürdige Bepflanzung. Alte oder mittelalte Straßenbäume bilden ein grünes Dach über Teilen der Straße. Geeignet sind Linden, Ahorn, Platanen. Die Bepflanzung wirkt städtisch robust, gepflegt und leicht unterschiedlich von Haus zu Haus.`
  - `6. Mittelgebirge – Kurort / Kleinstadt` → Promptwert: `### 7.3. Regionale Zuordnung: Mittelgebirge – Kurort / Kleinstadt Die Szene spielt in einer gepflegten Kleinstadt oder einem traditionsreichen Kurort in einem ostdeutschen Mittelgebirge. Alle sichtbaren Gebäude, Gärten, Straßenräume und Landschaftselemente müssen glaubwürdig zur historischen Kurortentwicklung, zur hügeligen Topografie und zum jeweiligen Baualter passen. * **Architektur und Umfeld:** Historische Fassaden, kleinere Villen, Pensionen, Bürgerhäuser und gepflegte Wohngebäude bilden eine ruhige kleinstädtische Straße. Typisch sind helle Putzfassaden, hohe Fenster, Veranden, dezente Holzdetails, gelegentlich Fachwerk oder Schiefer sowie kleine Gärten und Straßenbäume. Im Hintergrund oder zwischen den Gebäuden ist eine sanft hügelige bis bewaldete Mittelgebirgslandschaft erkennbar. * **Materialien und Grundstücksgestaltung:** Heller oder pastellfarbener Putz, Naturstein- und Bruchsteinsockel, Schiefer, Ziegel, Holz und historisch wirkende Metallteile sind regional plausibel. Wege und Eingänge bestehen aus Natursteinplatten, Pflaster, Kies oder zurückhaltendem Betonstein. Grundstücke sind sorgfältig gepflegt und können kleine Terrassen, Treppen, Stützmauern oder Kurort-typische Vorgartenbereiche aufweisen. * **Einfriedungen – sofern sichtbar:** Niedrige Mauern, Holzzäune oder geschnittene Hecken. Alternativ sind klassische Metallzäune mit dezenten Zierelementen, gegebenenfalls auf einem Naturstein- oder Putzsockel möglich. Die Einfriedung wirkt historisch passend, gepflegt und zurückhaltend und ist kein zwingender Bestandteil des Bildes, sofern sie nicht ausdrücklich verlangt wird. * **Vegetation:** Die sichtbaren Grünflächen und Pflanzbereiche zeigen eine für ein ostdeutsches Mittelgebirge und die beschriebene Jahreszeit glaubwürdige Bepflanzung. Gepflegte kleine Gärten mit Rasen, Stauden, Rosen, Hortensien, Rhododendren und heimischen Sträuchern passen zur Kurort-Anmutung. Straßenbäume und Gartenbäume können aus Linden, Ahorn, Kastanien, Buchen oder Obstgehölzen bestehen.`
  - `7. Kleinstadt – gewachsene Wohnstraße` → Promptwert: `### 7.3. Regionale Zuordnung: Kleinstadt – gewachsene Wohnstraße Die Szene spielt in einer ruhigen, über Jahrzehnte gewachsenen Kleinstadtstraße im Osten Deutschlands. Alle sichtbaren Gebäude, Vorgärten und Grundstückselemente müssen glaubwürdig die Mischung verschiedener Bauphasen und eine bodenständige, alltagstaugliche Nachbarschaft widerspiegeln. * **Architektur und Umfeld:** Gemischte Bebauung aus Einfamilienhäusern, Doppelhäusern, kleinen Mehrfamilienhäusern und vereinzelt älteren Handwerker- oder Bürgerhäusern. Unterschiedliche Dachformen, Fassadenbreiten und Grundstückszuschnitte zeigen eine gewachsene, vielfältige Struktur. Die Straße ist gepflegt, grün und bodenständig. * **Materialien und Grundstücksgestaltung:** Heller oder gedeckter Putz, Ziegel, Backstein, Betonstein, Natursteinsockel, Holz und schlichte Metallteile sind plausibel. Vorgärten, Zufahrten und Eingangsbereiche unterscheiden sich sichtbar in Alter und Ausführung; ältere Waschbetonplatten, modernisierte Pflasterflächen und einfache Kiesstreifen können nebeneinander vorkommen. Sanierte und weniger stark modernisierte Elemente dürfen sich glaubwürdig mischen. * **Einfriedungen – sofern sichtbar:** Schlichter Metall- oder Holzzaun, niedrige Mauer, einfacher Maschendraht- oder Stabgitterzaun oder geschnittene Hecke. Die Ausführung ist sauber, unaufdringlich und alltagstauglich und darf von Grundstück zu Grundstück variieren. * **Vegetation:** Sparsam begrünte Vorgärten mit Rasen, Hecken, Stauden, Rosen, Flieder, Hortensien, Obstbäumen und einzelnen Nadelgehölzen sind plausibel. Daneben existieren unbegrünte Plaster-, beton- oder Kiesflächen. Die Vegetation wirkt natürlich gewachsen und individuell gepflegt.`
  - `8. Flachland – offene Wohnsiedlung` → Promptwert: `### 7.3. Regionale Zuordnung: Flachland – offene Wohnsiedlung Die Szene spielt in einer weiten, flachen Wohnsiedlung im ostdeutschen Flachland, beispielsweise in Brandenburg oder Sachsen-Anhalt. Alle sichtbaren Gebäude, Wege, Vorgärten und Landschaftselemente müssen glaubwürdig zur offenen Siedlungsstruktur, zum hellen Himmel und zur regionalen Kulturlandschaft passen. * **Architektur und Umfeld:** Locker stehende Einfamilienhäuser und kleinere Doppelhäuser mit breiten Gehwegen, offenen Vorgärten und großzügigen Abständen. Die Bebauung kann aus unterschiedlichen Jahrzehnten stammen und umfasst schlichte Putzfassaden, Ziegel- oder Betondächer und vereinzelt modernisierte Häuser. Der Straßenraum wirkt hell, ruhig und weit; die flache Horizontlinie bleibt erkennbar. * **Materialien und Grundstücksgestaltung:** Heller Putz, Ziegel, Betonstein, einfache Klinkerflächen, Holz und zurückhaltendes Metall sind plausibel. Zufahrten und Wege bestehen aus Betonpflaster, Platten, Kies oder einfachen Asphaltanschlüssen. Vorgärten sind offen, funktional und individuell mit regional üblichen Materialien gestaltet. * **Einfriedungen – sofern sichtbar:** Niedriger heller Holzzaun, dezenter Metallzaun, Stabgitterzaun oder eine niedrige Hecke. Die Einfriedung bleibt transparent und freundlich und unterstützt die offene Wirkung der Siedlung. Sie ist kein zwingender Bestandteil des Bildes, sofern sie nicht ausdrücklich verlangt wird. * **Vegetation:** Die sichtbaren Grünflächen und Pflanzbereiche zeigen eine für das ostdeutsche Flachland glaubwürdige sparsame Bepflanzung. Geeignet sind Rasenflächen, robuste Stauden, Flieder, Rosen, Obstbäume, Birken, Kiefern, Ebereschen und vereinzelt Linden oder Ahorn. In der weiteren Umgebung können Baumreihen oder Alleen die offene Landschaft gliedern. Die Vegetation wirkt trockenheitsverträglich, locker gegliedert und der Jahreszeit entsprechend.`
  - `9. Plattenbau modernisiert` → Promptwert: `9. ### 7.3. Regionale Zuordnung: Ostdeutschland – Plattenbau modernisiert Die Szene spielt in einer modernisierten ostdeutschen Plattenbau-Wohnanlage mit sanierten fünfgeschossigen Mehrfamilienhäusern. Alle sichtbaren Fassaden, Freiflächen, Wege und Ausstattungen müssen glaubwürdig zur industriellen Bauweise der DDR-Zeit und zu einer späteren, qualitätsvollen Modernisierung passen. * **Architektur und Umfeld:** Mehrere fünfgeschossige Wohnblöcke in klarer, serieller Anordnung mit Flachdächern oder sehr flach geneigten Dächern, regelmäßig gesetzten Fenstern und modernisierten Balkonen. Fassaden sind wärmegedämmt und neu verputzt, dürfen aber die ursprüngliche Rasterstruktur noch erkennen lassen. Zwischen den Gebäuden liegen großzügige Grünflächen, Spielwege, Fußverbindungen und Aufenthaltsbereiche; die Anlage wirkt bewohnt, gepflegt, funktional und sichtbar modernisiert. * **Materialien und Grundstücksgestaltung:** Glatter oder fein strukturierter Putz, Beton, Faserzement- oder Metallbekleidungen, neue Fenster, beschichtete Balkongeländer und robuste Betonsteinbeläge sind plausibel. Farbflächen können einzelne Gebäudeteile oder Eingänge akzentuieren, bleiben jedoch zurückhaltend und architektonisch geordnet. Wege, Müllplätze, Fahrradbereiche und Spielzonen sind sachlich, sauber und gut nutzbar gestaltet. * **Einfriedungen – sofern sichtbar:** Niedriger funktionaler Metallzaun oder dezenter Begrenzungszaun entlang einer Grünfläche, eines Spielbereichs oder einer privaten Erdgeschosszone. Große Teile der gemeinschaftlichen Außenräume bleiben offen und durch Wege, Geländekanten oder Bepflanzung gegliedert. Einfriedungen sind nur dort sichtbar, wo sie funktional erforderlich sind. * **Vegetation:** Die sichtbaren Grünflächen und Pflanzbereiche zeigen eine für eine modernisierte ostdeutsche Großwohnsiedlung und die beschriebene Jahreszeit glaubwürdige Bepflanzung. Großzügige Rasenflächen, alte und nachgepflanzte Laubbäume, Strauchgruppen und einfache Staudenflächen prägen die Wohnanlage. Typisch sind Linden, Ahorn, Birken, Pappeln, Ebereschen und robuste Blütensträucher. Die Vegetation schafft Abstand, Übersicht und gemeinschaftliche Aufenthaltsqualität.`
  - `10. Sanierte Altbauten` → Promptwert: `### 7.3. Regionale Zuordnung: Sanierte Altbauten Die Szene spielt in einer ruhigen, sanierten Wohnstraße einer ostdeutschen Mittel- oder Großstadt. Alle sichtbaren Gebäude, Gehwege, Vorgärten und Straßenelemente müssen glaubwürdig zu einer gewachsenen Altbaulage mit sorgfältig modernisierter historischer Substanz passen. * **Architektur und Umfeld:** Mehrgeschossige Altbauten mit hellen Putzfassaden, hohen Fenstern, zurückhaltendem Stuck, Erkern oder Balkonen und klar gegliederten Hauseingängen. Großzügige Gehwege, alte Straßenbäume und eine ruhige städtische Atmosphäre prägen den Straßenraum. Die Häuser wirken saniert, bewohnt und als gewachsene historische Bausubstanz erkennbar. * **Materialien und Grundstücksgestaltung:** Heller oder pastellfarbener Putz, Naturstein- oder Ziegelsockel, historische Holztüren, Metallgeländer und erneuerte Fenster mit plausibler Teilung. Gehwege können aus großen Betonplatten, Natursteinborden und Pflasterstreifen bestehen. Kleine Vorgärten, Souterrainzugänge oder Innenhofdurchfahrten werden sauber und alltagstauglich gestaltet. * **Einfriedungen – sofern sichtbar:** Historisch wirkender Metallzaun mit schlichten Ornamenten, meist auf einem niedrigen Naturstein-, Ziegel- oder Putzsockel. Alternativ sind niedrige Mauern oder geschnittene Hecken möglich. Bei direkt an der Straße stehenden Gebäuden kann die Einfriedung entfallen; die konkrete Ausführung folgt dem Baualter und der Grundstückssituation. * **Vegetation:** Die sichtbaren Grünflächen und Pflanzbereiche zeigen eine für eine ostdeutsche Altbaustraße und die beschriebene Jahreszeit glaubwürdige Bepflanzung. Alte Linden, Ahorn, Kastanien oder Platanen bilden die wichtigste Straßenvegetation. Vorgärten zeigen schattenverträgliche Stauden, Efeu, Farne, Hortensien, Rosen und kleine Hecken. Die Vegetation wirkt gewachsen, städtisch robust und von Haus zu Haus leicht unterschiedlich.`
  - `11. Süddeutschland – alpennahe Wohnlage` → Promptwert: `### 7.3. Regionale Zuordnung: Süddeutschland – alpennahe Wohnlage Die Szene spielt in einer ruhigen alpen- oder voralpennahen Wohnlage in Süddeutschland. Alle sichtbaren Gebäude, Gärten und Landschaftselemente müssen glaubwürdig zur regionalen Bautradition, zur gepflegten Wohnumgebung und zum angedeuteten Alpen- oder Hügelland passen. * **Architektur und Umfeld:** Freistehende Einfamilienhäuser oder kleinere Doppelhäuser mit hell verputzten Fassaden, deutlichen Dachüberständen, Sattel- oder Krüppelwalmdächern und hochwertig ausgeführten Holzdetails. Balkone, Fensterläden oder holzverkleidete Giebel werden regional passend und handwerklich zurückhaltend eingesetzt. Im Hintergrund erscheinen sanfte Hügel, bewaldete Höhen oder eine zurückhaltende Alpenkulisse. * **Materialien und Grundstücksgestaltung:** Heller Putz, regionales Holz, rote bis braune Dachziegel, Naturstein, Kies und hochwertige Beton- oder Natursteinbeläge sind plausibel. Sockel, Treppen und niedrige Stützmauern können aus Naturstein bestehen; Eingänge und Zufahrten sind sauber und langlebig gestaltet. Die Grundstücke wirken gepflegt, hochwertig und regional bodenständig. * **Einfriedungen – sofern sichtbar:** Natürlicher Holzzaun mit klarer, hochwertiger Verarbeitung, alternativ eine niedrige Natursteinmauer, ein schlichter Metallzaun oder eine geschnittene Hecke. Die Einfriedung folgt dem Gelände und bleibt optisch leicht. Sie ist kein zwingender Bestandteil des Bildes, sofern sie nicht von der konkreten Szene ausdrücklich verlangt wird. * **Vegetation:** Die sichtbaren Grünflächen und Pflanzbereiche zeigen eine für eine alpennahe süddeutsche Wohnlage und die beschriebene Jahreszeit glaubwürdige Bepflanzung. Gepflegte Gärten mit Rasen, Obstbäumen, heimischen Laubgehölzen, Hortensien, Rosen, Geranien, Stauden und einzelnen Nadelgehölzen passen zur Region. Wiesenartige Randflächen und blühende Berg- oder Voralpenpflanzen können dezent sichtbar sein.`
  - `12. Süddeutschland – gepflegte Vorstadt` → Promptwert: `### 7.3. Regionale Zuordnung: Süddeutschland – gepflegte Vorstadt Die Szene spielt in einer gepflegten süddeutschen Vorstadt mit hell verputzten Häusern, Ziegeldächern und blühenden Vorgärten. Alle sichtbaren Gebäude, Grundstücke und Gestaltungselemente müssen glaubwürdig zu einer wohlgeordneten, gewachsenen Nachbarschaft im süddeutschen Raum passen. * **Architektur und Umfeld:** Freistehende Einfamilienhäuser, Doppelhäuser oder kleine Mehrfamilienhäuser mit hellen Putzfassaden, roten oder braunen Ziegeldächern, Dachüberständen und teilweise Balkonen. Die Straße ist ruhig, sauber und durch Vorgärten, Zufahrten und einzelne Straßenbäume gegliedert. Die Architektur wirkt hochwertig, bodenständig und klar süddeutsch geprägt. * **Materialien und Grundstücksgestaltung:** Heller Putz, Dachziegel, Naturstein, Holz, schmiedeeiserne oder dunkel beschichtete Metallteile sowie saubere Pflasterflächen sind plausibel. Vorgärten zeigen individuelle Wege, Stufen, kleine Mauern und Pflanzflächen. Die Gestaltung wirkt gepflegt und dauerhaft, darf aber Unterschiede zwischen älteren und jüngeren Häusern erkennen lassen. * **Einfriedungen – sofern sichtbar:** Hüfthoher Holzzaun oder schmiedeeiserner Zaun vor einem blühenden Vorgarten, alternativ niedrige Naturstein- oder Putzmauern und geschnittene Hecken. Kombinationen aus Mauerpfeilern, Metallfeldern und Bepflanzung sind möglich. Einfriedungen bleiben freundlich, hochwertig und zur Architektur passend; sie sind kein zwingender Bestandteil des Bildes. * **Vegetation:** Die sichtbaren Grünflächen und Pflanzbereiche zeigen eine für eine süddeutsche Vorstadt und die beschriebene Jahreszeit glaubwürdige Bepflanzung. Blühende Vorgärten mit Rosen, Hortensien, Lavendel in zurückhaltender Menge, Stauden, Geranien, Buchs- oder Hainbuchenhecken, Obstbäumen und gepflegtem Rasen. Die Bepflanzung wirkt saisonal, farbig, natürlich gewachsen und auf das süddeutsche Klima abgestimmt.`
  - `13. Dorf – klassischer Ortskern` → Promptwert: `### 7.3. Regionale Zuordnung: Dorf – klassischer Ortskern Die Szene spielt in einem klassischen süddeutschen Dorfkern mit Wohnhaus, Scheune oder altem Bauernhaus, ruhiger Straße und gewachsener Bausubstanz. Alle sichtbaren Gebäude, Hofbereiche und Gestaltungselemente müssen glaubwürdig zur dörflichen Geschichte, zum jeweiligen Baualter und zur regionalen Bauweise passen. * **Architektur und Umfeld:** Enger oder locker gefasster Dorfkern mit Einfamilienhaus, Bauernhaus, Scheune oder ehemaligem Wirtschaftsgebäude. Typisch sind große Sattel- oder Krüppelwalmdächer, Putzfassaden, Holzverschalungen, Fachwerkdetails und einfache Hoftore. Kopfsteinpflaster, Naturstein- oder Mischpflaster und eine ruhige Straße verstärken den gewachsenen, weiterhin genutzten Dorfcharakter. * **Materialien und Grundstücksgestaltung:** Heller Putz, Holz, Ziegel, Naturstein, altes Pflaster und handwerklich wirkende Metallteile sind plausibel. Hofräume und Grundstücke dürfen Spuren langfristiger Nutzung zeigen, bleiben jedoch gepflegt und funktional. Kleine Stufen, Brunnen, Holzstapel oder landwirtschaftliche Nebendetails sind möglich, sofern sie zurückhaltend und regional glaubwürdig bleiben. * **Einfriedungen – sofern sichtbar:** Traditioneller hüfthoher Holzzaun, leicht rustikal, aber gepflegt. Alternativ sind Natursteinmauern, einfache Metallzäune, Hoftore oder Hecken passend. Die Einfriedung richtet sich nach Hofstruktur und Gebäude und kann an offenen Hofzufahrten vollständig fehlen. * **Vegetation:** Die sichtbaren Grünflächen und Pflanzbereiche zeigen eine für einen süddeutschen Dorfkern und die beschriebene Jahreszeit glaubwürdige Bepflanzung. Blumenbeete, Bauerngartenpflanzen, Rosen, Stockrosen, Geranien, Kräuter, Obstbäume und heimische Sträucher passen zum Dorfkern. Kleine Rasen- oder Wiesenflächen und einzelne alte Laubbäume können sichtbar sein. Die Vegetation wirkt über Jahre gewachsen und verbindet Nutz-, Zier- und Obstpflanzen.`
  - `14. Mittelgebirge – Hangstraße` → Promptwert: `### 7.3. Regionale Zuordnung: Mittelgebirge – Hangstraße Die Szene spielt in einer süddeutschen Wohnstraße in leichter Hanglage mit freistehenden Häusern, Natursteinmauern und bewaldeten Hügeln. Alle sichtbaren Gebäude, Grundstücke und Landschaftselemente müssen glaubwürdig zur Topografie eines süddeutschen Mittelgebirgs- oder Voralpenraums passen. * **Architektur und Umfeld:** Freistehende Einfamilienhäuser oder kleinere Mehrfamilienhäuser staffeln sich entlang einer leicht ansteigenden Straße. Grundstücke liegen versetzt, Zufahrten und Eingänge folgen dem Gelände, und im Hintergrund erscheinen bewaldete Hügel oder weite grüne Hänge. Die Häuser zeigen helle Putzfassaden, geneigte Dächer und zurückhaltende Holz- oder Natursteindetails. * **Materialien und Grundstücksgestaltung:** Naturstein- und Bruchsteinmauern, heller Putz, Holz, Ziegel, Betonstein und Kies sind regional plausibel. Stufen, Böschungen, Terrassen und Stützmauern gliedern die Grundstücke. Die Gestaltung wirkt solide, landschaftsbezogen und an die Hanglage angepasst. * **Einfriedungen – sofern sichtbar:** Hüfthoher Holzzaun oder dunkler Metallzaun entlang eines leicht ansteigenden Grundstücks. Niedrige Natursteinmauern, Hecken oder Kombinationen aus Mauer und transparentem Zaun sind ebenfalls plausibel. Die Einfriedung folgt der Hangkante und bleibt funktional; sie ist kein zwingender Bestandteil des Bildes. * **Vegetation:** Die sichtbaren Grünflächen und Pflanzbereiche zeigen eine für eine süddeutsche Mittelgebirgs- oder Voralpenlage und die beschriebene Jahreszeit glaubwürdige Bepflanzung. Dichte heimische Gehölze, Rasen, Stauden und Hangbepflanzungen verbinden die Grundstücke mit der bewaldeten Umgebung. Geeignet sind Buchen, Ahorn, Eichen, Fichten in maßvoller Anzahl, Obstbäume, Hasel, Hortensien und robuste Bodendecker. Die Vegetation wirkt grün, leicht üppig und topografisch angepasst.`
  - `15. Großstadt – Neubauviertel` → Promptwert: `### 7.3. Regionale Zuordnung: Großstadt – Neubauviertel Die Szene spielt in einem modernen Neubauquartier einer wirtschaftsstarken süddeutschen Großstadt. Alle sichtbaren Gebäude, Freiräume und Ausstattungen müssen glaubwürdig zu zeitgenössischer Architektur, hoher Ausführungsqualität und einem gepflegten urbanen Wohnumfeld passen. * **Architektur und Umfeld:** Mehrgeschossige Wohngebäude mit klarer, zeitgemäßer Architektur, hellen Fassaden, großen Fenstern, Balkonen oder Loggien und sorgfältig proportionierten Baukörpern. Großzügige Gehwege, junge Bäume, gemeinschaftliche Freiflächen und klar gestaltete Eingangsbereiche prägen das Quartier. Die Szene wirkt urban, hochwertig, bewohnt und als gemischtes Wohnquartier gestaltet. * **Materialien und Grundstücksgestaltung:** Heller Putz, Sichtbeton in begrenzter Menge, Klinker- oder Natursteinakzente, Holz- oder Metallbekleidungen und hochwertige Pflasterflächen sind plausibel. Außenanlagen umfassen klare Wege, Sitzbereiche, Fahrradstellplätze und gut integrierte Müll- oder Technikzonen. Materialien und Farben bleiben zurückhaltend und aufeinander abgestimmt. * **Einfriedungen – sofern sichtbar:** Minimalistischer Metallzaun in Anthrazit oder Edelstahloptik, geradlinig und hochwertig. Alternativ können niedrige Mauern, bepflanzte Geländekanten oder transparente Abgrenzungen private Erdgeschossbereiche markieren. Einfriedungen sind sparsam einzusetzen und kein zwingender Bestandteil des Bildes. * **Vegetation:** Die sichtbaren Grünflächen und Pflanzbereiche zeigen eine für ein süddeutsches Neubauquartier und die beschriebene Jahreszeit glaubwürdige Bepflanzung. Junge Straßenbäume, strukturierte Staudenflächen, Gräser, Hecken und kleinere Rasen- oder Spielbereiche prägen die Außenanlagen. Geeignet sind klimaangepasste Laubbäume, Hainbuchenhecken, robuste Blütenstauden und zurückhaltende Gräserpflanzungen. Die Vegetation wirkt geplant, gepflegt und funktional in die Außenanlagen integriert.`
  - `16. Büroimmobilien` → Promptwert: `### 7.3. Regionale Zuordnung: Büroimmobilien Die Szene spielt an einer modernen Büroimmobilie in einer wirtschaftsstarken süddeutschen Mittel- oder Großstadt. Alle sichtbaren Gebäude, Eingangsbereiche und Außenanlagen müssen glaubwürdig zu einem repräsentativen, hochwertig gestalteten Unternehmensstandort passen. * **Architektur und Umfeld:** Moderne Büroimmobilie mit Glasfassade oder großflächigen Verglasungen, klar gegliederten Baukörpern, repräsentativem Eingangsbereich und präzisen Linien. Vorplatz, Zufahrt und Fußwege sind übersichtlich und hochwertig gestaltet. Die Architektur wirkt professionell, zeitgemäß und eindeutig als hochwertige Büroimmobilie lesbar. * **Materialien und Grundstücksgestaltung:** Glas, Metall, heller Naturstein, Betonwerkstein, hochwertiger Putz und einzelne Holzdetails sind plausibel. Pflanzkübel, Sitzmöglichkeiten, klare Pflasterflächen und sorgfältig integrierte Leuchten oder Beschilderungen ergänzen den Eingang. Technik-, Liefer- und Parkplatzbereiche sind optisch geordnet und treten gegenüber dem Haupteingang zurück. * **Einfriedungen – sofern sichtbar:** Niedrige architektonische Grundstücksbegrenzung aus Metall, Glas oder Naturstein, dezent und hochwertig. Alternativ können Geländekanten, Pflanzstreifen oder Poller die Bereiche gliedern. Massive Sicherheitszäune sind nur bei entsprechender Nutzung plausibel; grundsätzlich bleibt die Außenwirkung offen und repräsentativ. * **Vegetation:** Die sichtbaren Grünflächen und Pflanzbereiche zeigen eine für einen süddeutschen Bürostandort und die beschriebene Jahreszeit glaubwürdige Bepflanzung. Sorgfältig geplante Außenanlagen mit mehrstämmigen Gehölzen, jungen Laubbäumen, Gräsern, Stauden, geschnittenen Hecken und hochwertigen Pflanzkübeln. Die Bepflanzung ist klimaangepasst, gepflegt und architektonisch geordnet. Sie unterstützt den Eingang und die Aufenthaltsqualität und lässt die klare Fassadengestaltung gut erkennbar.`
  - `17. Bergisches Land – Fachwerk und Hanglage` → Promptwert: `### 7.3. Regionale Zuordnung: Bergisches Land – Fachwerk und Hanglage Die Szene spielt in einer gepflegten Wohnstraße im Bergischen Land mit Schieferfassaden, Fachwerkhäusern, grünen Hängen und dichter Vegetation. Alle sichtbaren Gebäude, Grundstücke und Landschaftselemente müssen glaubwürdig zur regionalen Baukultur und zur bewegten Topografie passen. * **Architektur und Umfeld:** Historische oder behutsam modernisierte Fachwerkhäuser, typische schwarz oder dunkel verschieferte Fassaden und weiß abgesetzte Fenster- und Holzteile prägen die Straße. Die Gebäude stehen in leichter bis deutlicher Hanglage und können durch Treppen, versetzte Eingänge und schmale Zufahrten erschlossen sein. Die Szene wirkt grün, niederschlagsgeprägt und über lange Zeit gewachsen. * **Materialien und Grundstücksgestaltung:** Dunkler Schiefer, weiß oder hell gestrichenes Fachwerk, Putz, Bruchstein, Naturstein, Holz und dunkel beschichtetes Metall sind regional plausibel. Stützmauern, Sockel und Treppen bestehen häufig aus Natur- oder Bruchstein; Wege und Zufahrten aus Pflaster, Betonstein oder Kies. Modernisierte Elemente fügen sich farblich und materiell in die traditionelle Umgebung ein. * **Einfriedungen – sofern sichtbar:** Hüfthoher dunkler Metallzaun oder schlichter Holzzaun vor einem gepflegten Vorgarten. Auch niedrige Bruchsteinmauern, Hecken oder Kombinationen aus Mauer und transparentem Zaun sind passend. Die Einfriedung folgt dem Hang und bleibt zurückhaltend; sie ist kein zwingender Bestandteil des Bildes. * **Vegetation:** Die sichtbaren Grünflächen und Pflanzbereiche zeigen eine für das Bergische Land und die beschriebene Jahreszeit glaubwürdige Bepflanzung. Dichte, niederschlagsverträgliche Vegetation mit Hecken, Farnen, Hortensien, Rhododendren, Stauden und moosigen oder bodendeckenden Flächen. Buchen, Eichen, Ahorn, Birken und Obstbäume sind plausibel. Die Bepflanzung wirkt üppig, grün und natürlich in die Hanglandschaft eingebunden.`
  - `18. Bergisches Land – modernes Einfamilienhaus` → Promptwert: `### 7.3. Regionale Zuordnung: Bergisches Land – modernes Einfamilienhaus Die Szene spielt in einer ruhigen Wohnlage im Bergischen Land mit modernisierten Einfamilienhäusern, leichter Hanglage, Natursteinmauern und dichtem Grün. Alle sichtbaren Bauteile und Außenanlagen müssen glaubwürdig regionale Material- und Landschaftsbindung verbinden. * **Architektur und Umfeld:** Modernisierte freistehende Einfamilienhäuser mit klaren, zeitgemäßen Ergänzungen. Die leichte Hanglage zeigt sich in versetzten Ebenen, Treppen, Terrassen oder einer teilweise sichtbaren Sockelzone. Dichtes Grün und bewaldete oder stark bepflanzte Grundstücksränder rahmen die ruhige Wohnlage. * **Materialien und Grundstücksgestaltung:** Heller oder gedeckter Putz, Schieferakzente, Natur- oder Bruchstein, Holz, Glas und anthrazitfarbenes Metall sind plausibel. Natursteinmauern und hochwertige Pflasterflächen gliedern Zufahrten und Gärten. Die Modernisierung wirkt hochwertig, regional eingebunden und auf die Hanglage abgestimmt. * **Einfriedungen – sofern sichtbar:** Hüfthohe niedrige Natursteinmauern oder Holz-Metall-Kombinationen mit sauber geschnittenen Hecken. Alternativ sind dunkle Metallzäune oder anthrazitfarbene Stabmattenzäune möglich. Einfriedungen folgen dem Grundstücksverlauf und können durch Hangbepflanzung teilweise verdeckt sein. * **Vegetation:** Die sichtbaren Grünflächen und Pflanzbereiche zeigen eine für Wohnlagen im Bergischen Land glaubwürdige Bepflanzung. Dichte Hecken, Farne, Hortensien, Rhododendren, Gräser, Stauden und heimische Laubbäume passen zur feuchten, grünen Region. Die Vegetation strukturiert einzelne moderne Gartenflächen und wirkt insgesamt natürlich und regional eingebunden.`
  - `19. Klassische Wohnsiedlung Reihenhäuser und Vorgärten` → Promptwert: `### 7.3. Regionale Zuordnung: Klassische Wohnsiedlung Reihenhäuser und Vorgärten Die Szene spielt in einer klassischen, gewachsenen westdeutschen Wohnsiedlung mit Reihenhäusern und gepflegten Vorgärten. Alle sichtbaren Gebäude, Außenbereiche und Gestaltungselemente müssen glaubwürdig zur Region, zur Siedlungsstruktur und zum jeweiligen Baualter passen. * **Architektur und Umfeld:** Gepflegte Wohnstraße mit Reihenhäusern, Vorgärten, Garagenzufahrten und einer glaubwürdigen, gewachsenen Nachbarschaft. Die Architektur wirkt typisch deutsch und bodenständig, nicht luxuriös oder übermäßig modern inszeniert. Keine Neubausiedlung. * **Materialien und Grundstücksgestaltung:** Regional plausible Materialien und Gestaltungselemente wie Klinker, Putz, Ziegel, Betonstein, schlichte Metall- oder Holzelemente, Zäune sowie natürlich gewachsene Hecken. Grundstücke und Vorgärten wirken individuell, gepflegt und über längere Zeit gewachsen, keine einheitliche Gestaltung. * **Einfriedungen – sofern sichtbar:** Zur Architektur passende niedrige Mauern, Ziegel- oder Klinkermauern, schlichte Metall- oder Holzzäune, Hecken oder zurückhaltende Kombinationen daraus. Die konkrete Ausführung richtet sich nach dem Gebäude, dem Grundstück und der jeweiligen Szene. Einfriedungen sind kein zwingender Bestandteil des Bildes, sofern sie nicht von der konkreten Szene ausdrücklich verlangt werden. * **Vegetation:** Die sichtbaren Vorgärten, Gärten und Grünflächen zeigen eine für Nordrhein-Westfalen und die beschriebene Jahreszeit glaubwürdige Bepflanzung. Geeignet sind grüne Hecken, Rasenflächen, Stauden sowie vereinzelt blühende Rosen oder Hortensien. Die Bepflanzung wirkt natürlich gewachsen, gepflegt und nicht dekorativ überladen. Keine tropischen, mediterranen oder für die Region untypischen Pflanzen als auffällige Hauptelemente.`
  - `20. Wohnstraße mit 50er-Jahre-Mehrfamilienhäusern` → Promptwert: `### 7.3. Regionale Zuordnung: Wohnstraße mit 50er-Jahre-Mehrfamilienhäusern Die Szene spielt in einer städtischen Wohnstraße eines westdeutschen Ballungsraums mit Mehrfamilienhäusern aus den 1950er-Jahren. Alle sichtbaren Gebäude, Freiflächen und Straßenelemente müssen glaubwürdig zur sachlichen Nachkriegsarchitektur, zu späteren Modernisierungen und zur lebendigen Verkehrsatmosphäre passen. Eine ÖPNV-Haltestelle darf weit hinten im Hintergrund am Straßenrand erkennbar sein, jedoch kein Bus und keine Straßenbahn. * **Architektur und Umfeld:** Drei- bis fünfgeschossige Mehrfamilienhäuser mit schlichten Putzfassaden, regelmäßig angeordneten Fenstern, kleinen Balkonen und funktionalen Eingängen. Straßenbäume, parkende Autos und kleine Vorgärten oder Grünflächen prägen die Wohnstraße. Die Gebäude dürfen teilweise energetisch modernisiert sein, müssen aber Proportionen und zurückhaltende Formensprache der 1950er-Jahre erkennen lassen. * **Materialien und Grundstücksgestaltung:** Heller oder gedeckter Putz, Beton, Ziegel- oder Klinkersockel, einfache Metallgeländer und robuste Betonsteinbeläge sind plausibel. Wege, Hauseingänge, Müllplätze und Stellflächen sind funktional, gepflegt und sachlich gestaltet. Modernisierte Bauteile wie neue Fenster oder Balkongeländer fügen sich sachlich in den Bestand ein. * **Einfriedungen – sofern sichtbar:** Niedrige Hecken, schlichte Mauersockel oder offene Rasenkanten vor einem kleinen Vorgarten oder einer gepflegten Grünfläche. Alternativ sind niedrige funktionale Metallzäune in Dunkelgrün oder Anthrazit möglich. Die Einfriedung kann bei gemeinschaftlich offenen Außenflächen entfallen. * **Vegetation:** Die sichtbaren Grünflächen und Pflanzbereiche zeigen eine für einen westdeutschen Ballungsraum und die beschriebene Jahreszeit glaubwürdige Bepflanzung. Straßenbäume, Rasenflächen, niedrige Hecken und robuste Strauchgruppen prägen das Grün. Geeignet sind Linden, Ahorn, Platanen, Birken, Liguster, Forsythien, Rosen und einfache Staudenflächen. Die Vegetation wirkt nicht überladen, jahrzehntelang gewachsen und alltagstauglich gepflegt.`
  - `21. Urbaner Vorort` → Promptwert: `### 7.3. Regionale Zuordnung: Urbaner Vorort Die Szene spielt in einem urbanen westdeutschen Vorort mit Mehrfamilienhäusern, gepflegten Gehwegen, Straßenbäumen und moderner Nachverdichtung. Alle sichtbaren Gebäude, Freiräume und Grundstückselemente müssen glaubwürdig die Mischung aus älterem Bestand und zeitgenössischen Ergänzungen zeigen. * **Architektur und Umfeld:** Mehrfamilienhäuser unterschiedlicher Baujahre stehen entlang einer gut erschlossenen, gepflegten Straße. Zwischen älteren Putz- oder Klinkerbauten erscheinen einzelne moderne Ergänzungen, Dachausbauten oder Neubauten auf zuvor ungenutzten Grundstücken. Die Nachverdichtung bleibt maßstäblich und vermittelt zwischen Bestand, Gehwegen, Vorgärten und Straßenbäumen. * **Materialien und Grundstücksgestaltung:** Putz, Klinker, Ziegel, Betonstein, Glas, Holz- und Metallelemente kommen in einer regional plausiblen Mischung vor. Zufahrten, Fahrradstellplätze, Müllbereiche und Eingänge sind kompakt und funktional integriert. Die Grundstücke wirken städtisch gepflegt, dürfen aber sichtbare Unterschiede zwischen älteren und neueren Gebäuden aufweisen. * **Einfriedungen – sofern sichtbar:** Hüfthoher moderner Metallzaun mit klaren Linien vor einem kleinen Vorgarten. Alternativ sind niedrige Klinker- oder Betonmauern, Hecken, Stabgitterzäune oder bepflanzte Übergänge möglich. Die konkrete Ausführung orientiert sich am jeweiligen Gebäude; in offenen Vorbereichen kann eine Einfriedung entfallen. * **Vegetation:** Die sichtbaren Grünflächen und Pflanzbereiche zeigen eine für einen westdeutschen urbanen Vorort und die beschriebene Jahreszeit glaubwürdige Bepflanzung. Straßenbäume, kleine Rasenflächen, Hecken, Stauden und robuste Sträucher gliedern den verdichteten Straßenraum. Alte Bäume können neben jungen Ersatzpflanzungen stehen. Die Vegetation wirkt gepflegt, stadtverträglich und entsprechend der unterschiedlichen Bauphasen vielfältig.`
  - `22. Metropole – urbanes Büro- und Neubauviertel` → Promptwert: `### 7.3. Regionale Zuordnung: Metropole – urbanes Büro- und Neubauviertel Die Szene spielt in einem innerstädtischen Büro- und Neubauviertel einer deutschen Metropole mit plausibler Frankfurt-/Rhein-Main- oder westdeutscher Großstadtwirkung. Alle sichtbaren Gebäude, Freiräume und Verkehrselemente müssen glaubwürdig zu hoher urbaner Dichte, moderner Architektur und einem gemischt genutzten Stadtquartier passen. Keine Straßenbahn. * **Architektur und Umfeld:** Bürogebäude, Neubauten und einzelne Hochhäuser mit Glasfassaden, klaren Baukörpern und repräsentativen Erdgeschosszonen bilden eine verdichtete Stadtkulisse. Breite Gehwege, Stadtverkehr, Eingänge, Vorplätze und vereinzelt gastronomische oder gewerbliche Nutzungen beleben das Quartier. Die Bildsprache kann sich an Berlin Neue Mitte oder Frankfurt orientieren; für die westliche Zuordnung wird sie vor allem über Frankfurt und den Rhein-Main-Raum gelesen. Maßstab, Straßenraum und Gestaltung bleiben eindeutig deutsch geprägt. * **Materialien und Grundstücksgestaltung:** Glas, Metall, Naturstein, Betonwerkstein, hochwertiger Putz und präzise Pflasterflächen dominieren. Erdgeschosse, Vorplätze und Eingänge sind sorgfältig gestaltet und können Sitzbereiche, Leuchten, Poller, Fahrradstellplätze oder dezente Kunstobjekte enthalten. Die Materialien wirken hochwertig, urban, belastbar und zeitgemäß. * **Einfriedungen – sofern sichtbar:** Niedrige moderne Metall- oder Betoneinfassung mit klaren Linien vor einer gepflegten Grünfläche, einem Bürovorplatz oder einer urbanen Wohnanlage. Alternativ dienen Pflanzbeete, Sitzkanten oder Poller als räumliche Begrenzung. Die Ausführung richtet sich nach Öffentlichkeit, Nutzung und Sicherheitsbedarf der jeweiligen Teilfläche. * **Vegetation:** Die sichtbaren Grünflächen und Pflanzbereiche zeigen eine für ein westdeutsches Metropolenquartier und die beschriebene Jahreszeit glaubwürdige Bepflanzung. Stadtverträgliche Bäume, strukturierte Pflanzbeete, Gräser, Stauden und einzelne begrünte Vorplätze setzen kontrollierte grüne Akzente. Geeignet sind robuste, klimaangepasste Laubbäume und architektonisch klare Pflanzungen. Die Vegetation ist der dichten Stadtsituation entsprechend dimensioniert und hält zentrale Fassaden und Hochhausansichten klar ablesbar.`
  - `23. Gewerbegebiet` → Promptwert: `### 7.3. Regionale Zuordnung: Gewerbegebiet Die Szene spielt in einem gepflegten Gewerbegebiet mit moderner Firmenimmobilie, Parkplätzen, Glasfassade und klar organisierten Zufahrten. Alle sichtbaren Gebäude, Außenflächen und technischen Elemente müssen glaubwürdig zu einem funktionalen, professionell betriebenen Unternehmensstandort passen. * **Architektur und Umfeld:** Moderne Firmenimmobilie mit Büro-, Dienstleistungs-, Produktions- oder Logistikanteilen, klar gegliederten Fassaden und einem erkennbaren Haupteingang. Parkplätze, Zufahrten, Lieferbereiche und Beschilderungen sind übersichtlich organisiert. Die Umgebung wirkt sachlich, sauber, professionell und eindeutig als gepflegter Unternehmensstandort. * **Materialien und Grundstücksgestaltung:** Glasfassaden oder verglaste Eingangsbereiche, Metallpaneele, Putz, Beton, Klinkerakzente und robuste Asphalt- oder Betonsteinflächen sind plausibel. Parkplätze und Fahrwege sind markiert und funktional, während der Eingangsbereich durch hochwertigere Beläge und Bepflanzung hervorgehoben wird. Technik- und Lagerbereiche sind geordnet und möglichst zurückhaltend sichtbar. * **Einfriedungen – sofern sichtbar:** Funktionaler hüfthoher Metallzaun oder Doppelstabmattenzaun in Anthrazit, sauber und professionell. Tore, Zufahrtskontrollen und niedrige Sockel können bei betrieblicher Notwendigkeit ergänzt werden. Die Einfriedung richtet sich nach Sicherheitsbedarf und Grundstücksnutzung und ist kein zwingender Bestandteil offener Büro- oder Dienstleistungsstandorte. * **Vegetation:** Die sichtbaren Grünflächen und Pflanzbereiche zeigen eine für ein westdeutsches Gewerbegebiet und die beschriebene Jahreszeit glaubwürdige Bepflanzung. Pflegeleichte Grünstreifen, junge Laubbäume, geschnittene Hecken, robuste Sträucher und einfache Staudenflächen gliedern Parkplätze und Grundstücksränder. Die Bepflanzung wirkt funktional und gepflegt und kann durch Regenmulden, begrünte Randbereiche oder einzelne Blühflächen ökologisch aufgewertet sein.`

### Bildformat

- API-Schlüssel in `values`: `2885`
- Typ: Einzelauswahl (`select`)
- Pflichtfeld: ja
- Zulässige Werte (genau die Bezeichnung senden):
  - `Querformat 16:9`
  - `Hochformat 9:16`
  - `Quadrat 1:1`

### Bildszene

- API-Schlüssel in `values`: `2886`
- Typ: Einzelauswahl (`select`)
- Pflichtfeld: ja
- Zulässige Werte (genau die Bezeichnung senden):
  - `A1 Makler lehnt am Vorgarten` → Promptwert: `* Die Maklerperson steht draußen an einer zur beschriebenen Umgebung und Architektur passenden, ungefähr hüfthohen Einfriedung und lehnt sich entspannt mit einem Ellbogen an einem geeigneten Abschnitt an. Die Einfriedung behält ihre regional und baulich typische, realistische Materialstärke. Kein Abstützen auf spitzen oder scharfkantigen Elementen. * Maklerperson blickt freundlich und unmittelbar direkt in das Kameraobjektiv. Beide Augen sind eindeutig auf denselben Punkt der Linse ausgerichtet und erzeugen natürlichen Blickkontakt mit dem Betrachter * Der Gesichtsausdruck zeigt ein warmes, entspanntes Halblächeln mit geschlossenem oder nur minimal geöffnetem Mund und sanft mitlächelnden Augen. * Die Körperhaltung wirkt natürlich, sicher und ungezwungen. * Die Maklerperson vermittelt den Eindruck, mit der Nachbarschaft und dem Wohnumfeld bestens vertraut zu sein. * Die gewünschte Bildwirkung ist nahbar, sympathisch und sommerlich-entspannt, mit einer warmen, menschlichen Ausstrahlung, jedoch ohne übertriebene Werbeinszenierung. ### 8.3. Bildaufbau, Perspektive und Licht * Die Maklerperson wird aus einer natürlichen, unverzerrten Perspektive dargestellt. Gesicht, Oberkörper, aufgestützter Ellbogen und relevante Gesten sind vollständig und gut erkennbar. Die Person ist glaubwürdig in die Umgebung eingebunden und wirkt weder übermäßig zentral noch künstlich freigestellt. * Die Maklerperson befindet sich im offenen Teilschatten und wird ausschließlich durch natürlich aussehendes Umgebungslicht beleuchtet. * Das Gesicht ist entsprechend des Lichteinfallwinkels ausgeleuchtet, mit dezenten Lichtreflexen aber ohne harte Schatten. Die Augen sind erkennbar, lebendig und natürlich beleuchtet; Iris, Blickrichtung und Ausdruck bleiben deutlich lesbar. Keine keine verdeckten Augen und keine unnatürlich starken Lichtreflexe auf Brillengläsern. ### 8.4. Schärfe, Tiefenwirkung und Integration * Fujifilm X-T5 mit 35-mm-Objektiv, entsprechend ca. 53 mm KB-äquivalent, Aufnahme bei f/5.6, 1/125s und ISO 400 * Der optische Fokus liegt auf der Maklerperson und dem unmittelbar angrenzenden Umgebungsbereich. Beide besitzen eine zueinander passende, natürliche Schärfecharakteristik. Vom Vordergrund über die Person bis in den Hintergrund entsteht ein sehr leichter und fotografisch glaubwürdiger Schärfeverlauf. * Der Hintergrund zeigt eine sehr dezente, realistische Tiefenunschärfe, bleibt jedoch detailliert als tatsächliche Umgebung erkennbar. * Mittlere Tiefenschärfe Keine übertriebene Schärfentrennung zwischen Person und Hintergrund, keine messerscharfen oder ausgestanzt wirkenden Konturen, keine künstliche Freistellung, kein extremer Bokeh-Effekt und keine vollständig aufgelöste Umgebung. * Kein Smartphone-Portraitfilter. * Lichtrichtung, Lichtintensität, Farbtemperatur und Schattencharakter der Maklerperson müssen mit der unmittelbaren Umgebung übereinstimmen. An den Kontaktstellen zwischen Körper, Kleidung und Einfriedung entstehen glaubwürdige Kontakt- und Umgebungsschatten. Keine abweichende Beleuchtung und keine künstlich aufgehellte Person vor einem anders beleuchteten Hintergrund. ### 8.5. Inszenierung * Natürliches, locker inszenierte Environmental Business Aufnahme mit hochwertiger redaktioneller Anmutung. Die Haltung wirkt entspannt, authentisch und glaubwürdig, nicht steif, übermäßig gestellt oder stockfotoartig. * Der Gesichtsausdruck darf nicht ernst, distanziert, melancholisch, müde, verschlossen oder mit starrem Blick wirken. Die Maklerperson darf nicht älter oder erschöpfter wirken als auf den Referenzbildern. Ein übertriebenes, künstliches oder offensichtlich gestelltes Werbelächeln ist nicht erlaubt.`
  - `A2 Gespräch auf dem Wochenmarkt` → Promptwert: `* Ein freundlicher Marktverkäufer steht gemeinsam mit der Maklerperson zentral im Bild an einem Gemüsestand. * Die Maklerperson steht rechts im Bild mit Einkaufskorb und wählt frisches Gemüse aus. * Der Marktverkäufer steht ihr zugewandt gegenüber, spricht freundlich mit ihr und hält eine geöffnete Papiertüte bereit. * Im Vordergrund liegen frischer Salat, Tomaten, Zucchini, Auberginen und weiteres natürlich arrangiertes Marktangebot. * Die Szene vermittelt lokale Verbundenheit, Nahbarkeit und einen entspannten Kontakt im Wohnumfeld. * Alle Materialien und Waren wirken frisch, realistisch und markenfrei. Keine Logos, lesbare Schrift, Wasserzeichen oder künstliche Werbeinszenierung. ### 8.3. Bildaufbau, Perspektive und Licht * Die Maklerperson und der Marktverkäufer stehen gemeinsam zentral an einem Gemüsestand. Beide Personen sowie ihre relevanten Gesten sind vollständig und gut erkennbar. * Halbweite Totale aus natürlicher, unverzerrter Perspektive. Die Hauptfiguren bilden den visuellen Schwerpunkt, während ausreichend Umgebung sichtbar bleibt, um den Wochenmarkt eindeutig zu erkennen. * Natürliches Tageslicht mit weicher, gleichmäßiger Ausleuchtung. Dezente Sonnenreflexe dürfen im Hintergrund und auf dem Marktangebot sichtbar sein, ohne harte Schatten oder dramatische Lichtwirkung. ### 8.4. Schärfe, Tiefenwirkung und Integration * Fujifilm X-T5 mit 18-mm-Objektiv, entsprechend ca. 27 mm KB-äquivalent, Aufnahme bei f/5.6, 1/250s und ISO 250. * Der optische Fokus liegt auf den Gesichtern und der Interaktion beider Hauptfiguren. Gemüse und Stand im unmittelbaren Umfeld bleiben ausreichend deutlich erkennbar. * Der Hintergrund zeigt eine dezente, realistische Tiefenunschärfe, bleibt jedoch als belebter Wochenmarkt lesbar. Keine künstliche Freistellung und kein extremer Bokeh-Effekt. * Licht, Farbtemperatur und Schatten beider Personen stimmen glaubwürdig mit Marktstand und Umgebung überein. ### 8.5. Inszenierung * Natürlich wirkende Alltagsszene mit hochwertiger redaktioneller Anmutung. Die Interaktion wirkt spontan, freundlich und glaubwürdig, nicht gestellt oder stockfotoartig. * Beide Personen zeigen eine offene, entspannte Körpersprache und ein dezentes, natürliches Lächeln. Keine übertriebene Werbegestik und kein direkter Blick in die Kamera.`
  - `A3 Drohne im Vordergrund` → Promptwert: `* Die Maklerperson steht unter einem hellen, blauen Sommerhimmel. Die niedrige Kameraposition zeigt sie leicht von unten und erzeugt eine souveräne, moderne Dynamik. * Die rechte Hand hält eine schwarze Quadcopter-Drohne von unten am zentralen Gehäuse. Der nach unten ausgestreckte Arm bringt sie nah an das Objektiv. Die Finger greifen sicher, ohne Propeller oder empfindliche Bauteile unlogisch zu berühren. * Die Drohne ist ausgeschaltet und wird ruhig gehalten. Die Zweiblattpropeller stehen still. Zwei Propellerblätter stehen einander jeweils an jedem Propeller genau gegenüber. Keine fliegende Drohne, rotierenden Propeller oder antriebsbedingte Bewegungsunschärfe. * Die linke Hand hält eine passende schwarze Fernsteuerung in natürlicher Position. Hände, Finger und Bedienelemente sind plausibel angeordnet. Keine zusätzlichen Geräte, Kabel oder unlogischen Bauteile. * Die Maklerperson blickt konzentriert auf die Drohne. Die Augen sind auf die Drohne in der rechten Hand ausgerichtet. Der Blick vermittelt Aufmerksamkeit, technisches Verständnis und sicheren Umgang. Kein Stirnrunzeln, starrer Blick oder übertriebener Ausdruck. * Nur minimales Lächeln bis neutrales Gesicht mit geschlossenem Mund. * Die Körperhaltung wirkt natürlich und sicher. Die Maklerperson vermittelt den Eindruck, die Drohne routiniert für die Präsentation oder Dokumentation von Immobilien einzusetzen. * Keine Logos, Markenkennzeichen, sichtbaren Texte, Wasserzeichen oder weiteren Personen. ### 8.3. Bildaufbau, Perspektive und Licht * Die Maklerperson wird aus einer niedrigen, leicht aufwärts gerichteten Kameraperspektive dargestellt. Die Untersicht wirkt dynamisch und dezent dramatisch, bleibt jedoch natürlich. Gesicht, Oberkörper, ausgestreckter rechter Arm, Hände, Drohne und Fernsteuerung sind gut erkennbar. * Die nahe an der Kamera positionierte Drohne bildet einen markanten Vordergrund. Gesicht und Oberkörper der Maklerperson bleiben der visuelle Schwerpunkt und sind im optischen Fokus. * Die Maklerperson steht draußen unter einem hellen Sommerhimmel und wird ausschließlich durch natürliches Sonnen- und Umgebungslicht beleuchtet. Keine Gebäude, Leitungen oder ablenkenden Elemente. * Das Gesicht ist der Umgebung entsprechend ausgeleuchtet. Augen, Iris, Blickrichtung und Ausdruck bleiben trotz der niedrigen Perspektive deutlich erkennbar. Keine extremen Augenschatten oder verdeckten Augen. ### 8.4. Schärfe, Tiefenwirkung und Integration * Fujifilm X-T5 mit 23-mm-Objektiv, entsprechend ca. 35 mm KB-äquivalent, Aufnahme bei f/4, 1/1000 s und ISO 160. * Der optische Fokus liegt auf Gesicht und Augen. Gesicht und Oberkörper sind natürlich scharf dargestellt. Fernsteuerung und körpernaher Armbereich besitzen eine dazu passende Schärfecharakteristik. * Die schwarze Quadcopter-Drohne befindet sich nah an der Kamera und ist liegt leicht außerhalb der Schärfeebene. Form, Propellerarme und Bauweise bleiben eindeutig erkennbar. Keine konturlose oder unkenntliche Drohne. * Vom Vordergrund über den ausgestreckten Arm bis zur Person entsteht ein glaubwürdiger Schärfeverlauf mit deutlicher räumlicher Tiefe. Keine künstlich zusammengesetzten Bildelemente. * Keine ausgestanzten Konturen, künstliche Freistellung, extremes Bokeh oder Smartphone-Portraitfilter. * Perspektive und ausgestreckter Arm dürfen einzelne Bildelemente leicht betonen. Gesicht, Hände, Finger, Arme und Geräte behalten plausible Proportionen. Keine übergroßen Hände, verlängerten Arme oder verzerrten Gesichtszüge. * Lichtrichtung, Intensität, Farbtemperatur und Schattencharakter stimmen bei Person und Geräten überein. Zwischen Händen und Geräten entstehen glaubwürdige Kontaktschatten. Keine abweichend beleuchteten Bildelemente.`
  - `A4 Drohne im Hintergrund` → Promptwert: `* Die Maklerperson steht als Drohnenpilot rechts in einer mittleren Tiefenebene des Bildes. * Im weiter entfernten Hintergrund sind Elemente aus der regionalen Zuordnung zu sehen. * Im direkten Hintergrund befindet sich eine Freifläche, einzelne Bäume und viel offener Himmel. * Links im Bildvordergrund fliegt eine schwarze Drohne in glaubwürdiger Entfernung neben und vor der Maklerperson. * Die Maklerperson schaut genau zur Drohne. * Die Szene vermittelt moderne, professionelle technische Kompetenz, ohne dass die Technik zum dominanten Hauptmotiv wird. * Keine weiteren Personen, Logos, lesbare Schrift oder Wasserzeichen. ### 8.3. Bildaufbau, Perspektive und Licht * Die Maklerperson steht rechts im Vordergrund des Bildes. * Kameraperspektive: halbweite Totale. * Im Hintergrund bleibt ausreichend offener Himmel sichtbar, sodass die fliegende Drohne klar erkennbar ist. * Natürliches, klares Tageslicht an einem freundlichen Frühsommertag. * Lichteinfall und Eigenschatten der Maklerperson entsprechen glaubwürdig den Lichtverhältnisse der Umgebung. ### 8.4. Schärfe, Tiefenwirkung und Integration * Fujifilm X-T5 mit 16-mm-Objektiv, entsprechend ca. 27 mm KB-äquivalent, Aufnahme bei f/5.6, 1/500s und ISO 200. * Der optische Fokus liegt auf der Maklerperson. * Die Drohne bleibt als kompakte schwarze Kameradrohne erkennbar, ist jedoch entsprechend ihrer Bewegung etwas weniger scharf als die Person. * Die Elemente im Hintergrund bilden eine glaubwürdige räumliche Umgebung. Natürliche Größenwirkung der Drohne. Keine künstliche Freistellung von Maklerperson oder Drohne. ### 8.5. Inszenierung * Locker inszeniertes Außen-Portrait mit redaktioneller Anmutung. * Die Maklerperson trägt einen entspannten privaten Casual Look, steht sicher und hält die Fernsteuerung mit beiden Händen vor dem Körper. * Falls gesicht sichtbar: Freundlicher direkter Blick zur Drohne mit natürlichem Lächeln mit geschlossenem Mund. * Keine starre Pilotenpose, übertriebene Technikinszenierung oder werbliche Gestik.`
  - `A5 Makler steht mit Paar vor Objekt` → Promptwert: `* Die Maklerperson steht mit einem Paar in den 30ern vor einem Objekt * Die Maklerperson hält unter einem Arm sicher eine Mappe oder ein geschlossenes Exposé. * Mit dem freien Arm weist sie erklärend und anatomisch plausibel auf das Objekt im Hintergrund. * Das Paar richtet den Blick zur Maklerperson oder folgt der Geste zum Haus. * Die Immobilie wirkt gepflegt und realistisch, jedoch nicht luxuriös oder wie ein Neubau-Showroom inszeniert. * Die Szene vermittelt persönliche Beratung, Ortskenntnis und eine glaubwürdige Objektbesichtigung. * Keine weiteren Personen, Logos, lesbare Schrift oder Wasserzeichen. ### 8.3. Bildaufbau, Perspektive und Licht * Die Szene wird aus einer natürlichen, unverzerrten Perspektive entsprechend der regionalen Zuordnung dargestellt. * Die Maklerperson steht leicht versetzt vor dem Objekt und ist von vorne oder im Dreiviertelprofil sichtbar. * Das Paar steht inj natürlicher Pose im Vordergrund, überwiegend mit dem Rücken zur Kamera. * Weite Totale mit ausgewogenem Bildaufbau. Die Maklerperson bildet den visuellen Schwerpunkt, während Paar und Immobilie klar in die Beratungssituation eingebunden bleiben. * Großzügiger Bildausschnitt, der alle Personen und die Umgebung erfasst. ### 8.4. Schärfe, Tiefenwirkung und Integration * Fujifilm X-T5 mit 24-mm-Objektiv, entsprechend ca. 36 mm KB-äquivalent, Aufnahme bei f/5.6, 1/250s und ISO 250. * Der optische Fokus liegt auf Gesicht, Augen und erklärender Geste der Maklerperson. Das Paar bleibt ausreichend deutlich erkennbar. * Das Objekt im Hintergrund zeigt eine sehr dezente, realistische Tiefenunschärfe, bleibt jedoch architektonisch klar lesbar. * Personen, Grundstück und Gebäude besitzen eine zusammenhängende, glaubwürdige Licht- und Schärfecharakteristik. Keine künstliche Freistellung oder unnatürlichen Konturen. ### 8.5. Inszenierung * Natürlich wirkende Beratungssituation mit hochwertiger redaktioneller Anmutung. Die Szene wirkt kompetent, offen und vertrauensbildend, nicht gestellt oder werblich überinszeniert. * Die Maklerperson spricht mit dem Paar und blickt zum Paar. Das Paar hört aufmerksam zu. * Die Maklerperson blickt nicht in die Kamera. * Alle Personen zeigen eine alltägliche, offene, entspannte Körpersprache ohne starre Präsentationspose.`
  - `B1 Schlüsselübergabe` → Promptwert: `* Die Maklerperson übergibt einer Kundin freundlich einen Schlüsselbund in einem stehenden Moment der Übergabe in einem Immobilienmakler-Büro. * Beide Personen stehen sich in natürlicher Gesprächsdistanz gegenüber. Die Maklerperson bleibt das klare Hauptmotiv; die Kundin steht rechts im Bild als sichtbares, aber untergeordnetes Gegenüber. * Gezeigt wird der kurze Zwischenmoment unmittelbar vor dem Loslassen: Die Kundin hat den Schlüsselbund mit den Fingern bereits leicht erfasst, während die Maklerperson den Schlüsselring noch locker hält. * In diesem bereits erreichten Greifmoment sehen sich beide Personen freundlich an. Niemand schaut in die Kamera oder während des Griffes suchend auf Schlüssel oder Hände. * Hände, Fingerhaltung und die räumliche Beziehung zwischen beiden Händen sind anatomisch plausibel und als echte Übergabe eindeutig nachvollziehbar. * Sichtbare Unterlagen, Möbel und Büroelemente bleiben hochwertig, markenfrei, unlesbar und ohne dominanten Neubaucharakter. ### 8.3. Bildaufbau, Perspektive und Licht * Großzügige halbnahe stehende Zweipersonenszene auf Augenhöhe mit natürlicher, unverzerrter Perspektive. Gesicht, Oberkörper, Schlüsselbund und Übergabegeste der Maklerperson sind vollständig und ohne enge Randlage erkennbar. * Die Kamera steht leicht seitlich versetzt zur Blickachse der beiden Personen. Die Kundin bleibt in leichter Profil- oder Dreiviertelansicht sichtbar und wird nicht als große Vordergrundfigur inszeniert. * Das Gesicht der Maklerperson liegt gleichmäßig in neutralem Fenster-Tageslicht, ohne warme oder kühle Farbstiche auf der Haut. ### 8.4. Schärfe, Tiefenwirkung und Integration * Fujifilm X-T5 mit 35-mm-Objektiv, ca. 53 mm KB-äquivalent, f/4 bis f/5.6, 1/125 s, ISO 400. * Primäre Schärfe auf Gesicht und Augen der Maklerperson; zugleich bleiben Schlüsselbund, Übergabehände sowie Augenpartie und wesentliche Gesichtszüge der Kundin klar genug für eine glaubwürdige Interaktion erkennbar. * Dezente, räumlich plausible Tiefenunschärfe mit weichem Schärfeverlauf in den Hintergrund; beide Personen bleiben natürlich in die Umgebung integriert, ohne Freistellungs- oder Fotomontage-Look. ### 8.5. Inszenierung * Authentischer, freudiger Moment einer echten Schlüsselübergabe. Beide Personen wirken emotional aufeinander bezogen, locker und situationsbezogen. * Ein natürliches freundliches Lächeln oder leichtes gemeinsames Lachen ist ausdrücklich passend, als Reaktion auf einen netten oder humorvollen Moment während der Übergabe. * Die Kundin ist eine sympathische Frau mittleren Alters und wirkt wie eine reale Kundin aus dem Alltag: gepflegt, individuell und ungekünstelt, nicht wie ein gecastetes Fotomodell oder Beauty-Motiv. * Der Blickkontakt wirkt wie ein kurzer sozialer Moment innerhalb der bereits laufenden Übergabe und nicht wie bewusstes Posieren für die Kamera. * Die Übergabebewegung bleibt selbstverständlich: Die Kundin übernimmt den Schlüsselbund tatsächlich, während die Maklerperson gerade loslässt; der Schlüsselbund wird nicht wie ein Werbeobjekt präsentiert.`
  - `B2 Telefonat mit Kunden im Büro` → Promptwert: `* Die Maklerperson sitzt oder steht in einem hellen, gepflegten Immobilienmaklerbüro und führt mit einem Smartphone ein Kundentelefonat. * Die Maklerperson spricht mit einem freundlichen Halblächeln ins Smartphone. * Der Blick richtet sich leicht seitlich, auf den Schreibtisch oder aus dem Fenster und vermittelt aktives, konzentriertes Zuhören. Die Person blickt nicht direkt in die Kamera. * Auf einem angrenzenden Schreibtisch dürfen ein geschlossener oder geöffneter Laptop, markenfreie Exposés, nicht lesbare Unterlagen, Grundrisse und einzelne Schlüssel liegen. Die Gegenstände bleiben realistisch angeordnet und dürfen die Szene nicht überladen. * Das Smartphone ist neutral, markenfrei und wird in einer plausiblen Position am Ohr gehalten. Keine unnatürliche Handhaltung, keine verdeckten Finger und keine missverständliche Bedienung des Geräts. * Die gewünschte Bildwirkung ist professionell, aufmerksam, nahbar und vertrauensbildend. Die Szene vermittelt den glaubwürdigen Büroalltag eines erfahrenen deutschen Immobilienmaklers, ohne übertriebene Werbeinszenierung. ### 8.3. Bildaufbau, Perspektive und Licht * Die Maklerperson wird aus einer natürlichen, unverzerrten Perspektive im hellen Immobilienbüro dargestellt. Gesicht, Oberkörper, Smartphone und telefonierende Hand sind vollständig und gut erkennbar. Die Person wirkt glaubwürdig in die Arbeitsumgebung eingebunden und nicht künstlich freigestellt. * Das Gesicht ist dem Raum entsprechend ausgeleuchtet, ohne harte Schatten, sichtbaren Blitz oder erkennbare künstliche Lichtquellen. Gesichtsausdruck und aktives Gespräch müssen eindeutig lesbar sein. * Die Augen bleiben klar erkennbar. Keine unnatürlich starken Lichtreflexe auf Brillengläsern. ### 8.4. Schärfe, Tiefenwirkung und Integration * Fujifilm X-T5 mit 35-mm-Objektiv, entsprechend ca. 53 mm KB-äquivalent, Aufnahme bei f/5.6, 1/125 s und ISO 400. * Der optische Fokus liegt auf Gesicht und Augen. Smartphone, Hände und unmittelbar angrenzende Objekte bleiben ausreichend scharf und natürlich integriert. * Der Hintergrund zeigt eine dezente, realistische Tiefenunschärfe, bleibt jedoch eindeutig als realistisches Immobilienmaklerbüro erkennbar. Keine ausgestanzt wirkenden Konturen und kein künstlicher Smartphone-Portraitfilter. * Lichtrichtung, Farbtemperatur, Schlagschatten und Eigenschatten der Person stimmen mit der Büroeinrichtung und dem durch die Fenster einfallenden Licht überein. ### 8.5. Inszenierung * Natürliches glaubwürdiges Business Portrait während eines Kundenkontakts. * Die Szene wirkt beobachtet und authentisch, nicht wie eine gestellte Inszenierung oder ein austauschbares Stockfoto. * Kein übertriebenes Werbelächeln, kein demonstratives Lachen. * Körperhaltung, Griff des Smartphones und Position der telefonierenden Hand wirken entspannt und anatomisch korrekt.`
  - `B3 Beratungsgespräch mit Senioren im Büro` → Promptwert: `* Die Maklerperson sitzt links im Profil, erklärt einen Punkt und gestikuliert natürlich mit einer Hand in Richtung der Unterlagen. * Ein älterer Mann sitzt mittig, lehnt sich leicht vor, prüft den Grundriss und zeigt auf eine konkrete Stelle im Plan. * Eine ältere Frau sitzt rechts, zum Tisch gedreht, hält ein größeres Dokument beziehungsweise Exposé in natürlicher Arbeits- und Leseposition und verfolgt abwechselnd Unterlagen und Gespräch. * Gezeigt wird ein beobachteter Arbeitsmoment innerhalb der Beratung, nicht ein gleichmäßig posierter Dreiermoment: Die Aufmerksamkeit verteilt sich natürlich auf Plan, Dokument und Gesprächspartner. * Auf dem aufgeräumten Tisch liegen Grundrisse, Schreibutensilien und ein geöffneter, zur Gruppe gedrehter Laptop; die Unterlagen werden sichtbar genutzt, nicht nur präsentiert. * Die Szene vermittelt eine vertrauensvolle Immobilienberatung im Moment einer gemeinsamen Abwägung und Entscheidung. ### 8.3. Bildaufbau, Perspektive und Licht * Ruhige, medium-weite Aufnahme aus leicht erhöhter und leicht seitlich versetzter Perspektive. Alle drei Personen sowie die wesentlichen Unterlagen auf der Arbeitsfläche sind gut erkennbar. * Die Kunden werden fotografisch unterschiedlich gewichtet: Jeweils nur eine der beiden Nebenpersonen erscheint mit dem Gesicht klarer und offener lesbar; die andere bleibt stärker seitlich, leicht zurückgenommen oder sichtbar durch ihre aktuelle Tätigkeit mit Plan beziehungsweise Exposé gebunden. Beide Kunden werden nicht gleichzeitig wie gleichwertige Porträtmotive präsentiert. * Die Frau bleibt dabei klar innerhalb der gemeinsamen Tischgruppe und mit sichtbarem Abstand zum rechten Bildrand. Sie befindet sich ungefähr auf derselben räumlichen Tiefenebene wie der ältere Mann oder nur leicht versetzt und wird nicht als nahes, großflächiges Vordergrundelement inszeniert. * Die Maklerperson und die gemeinsam genutzte Arbeitsfläche bilden den visuellen Schwerpunkt; die Kunden bleiben als glaubwürdige Gesprächspartner in die Szene eingebunden. * Helles, weiches Tageslicht in einem gepflegten, weiß geprägten Büro. * Die Arbeitsfläche verbindet die drei Personen sichtbar; der Raum bleibt als natürlicher Beratungskontext erkennbar, ohne die Szene zu dominieren. ### 8.4. Schärfe, Tiefenwirkung und Integration * Fujifilm X-T5 mit 23-mm-Objektiv, ca. 35 mm KB-äquivalent, f/5.6, 1/125 s, ISO 500. * Optischer Fokus auf Gesichter, Gesten und die genutzten Unterlagen. Alle Beteiligten bleiben ausreichend scharf. * Dezente Tiefenwirkung, keine extreme Freistellung oder verzerrte Proportionen. ### 8.5. Inszenierung * Dokumentarisch wirkender Beratungszwischenmoment statt idealisierter Gruppenpose. * Freundliche, ruhige und alltagsnahe Mimik; offene Gesprächsatmosphäre ohne durchgehendes Werbelächeln. * Kopfhaltung, Blickrichtung und Sichtbarkeit der Kunden entstehen aus Lesen, Prüfen, Nachdenken und Reagieren. Die beiden Kunden wirken nicht wie gemeinsam präsentierte Co-Models, sondern wie unterschiedlich stark sichtbare Beteiligte eines laufenden Beratungsmoments. * Die fotografisch zurückgenommene Nebenperson bleibt dennoch natürlich und vollständig in die gemeinsame Beratungssituation eingebunden; ihre geringere Präsenz entsteht durch Blickwinkel und Tätigkeit, nicht durch eine randnahe oder stark vorgelagerte Position. * Alle Beteiligten sind aufmerksam eingebunden, aber nicht gleichzeitig gleich stark präsentierend; kein Blick in die Kamera.`
  - `B4 Konzentriertes Arbeiten` → Promptwert: `* Die Maklerperson sitzt am Schreibtisch und arbeitet mit Laptop, Unterlagen und Notizblock. * Die Maklerperson schaut neutral aber nicht unfreundlich. * Die Materialien sind realistisch angeordnet, neutral, seriös und markenfrei. * Sichtbare Dokumente bleiben unlesbar und vermitteln keinen reinen Neubauvertrieb. * Die Bildwirkung ist sachlich, kompetent und authentisch. ### 8.3. Bildaufbau, Perspektive und Licht * Natürliche Aufnahme auf Augenhöhe am Schreibtisch. Gesicht, Hände und Arbeitsmaterialien sind gut sichtbar. * Weiches, diffuses Fensterlicht erhellt Person und Arbeitsplatz gleichmäßig und neutral. * Gesicht und Hände liegen ruhig im Licht, ohne auffällige warme oder kühle Farbstiche; die Fenster bleiben hell, aber ohne ausfressende Überstrahlung. * Der Blick der Maklerperson richtet sich auf Bildschirm oder Unterlagen, nicht in die Kamera. ### 8.4. Schärfe, Tiefenwirkung und Integration * Fujifilm X-T5 mit 35-mm-Objektiv, ca. 53 mm KB-äquivalent, f/5.6, 1/125 s, ISO 400. * Optischer Fokus auf Gesicht, Hände und aktuellen Arbeitsbereich. * Hintergrund nur dezent unscharf; Bürostruktur, Möbel und räumliche Tiefe bleiben klar erkennbar. * Die Schärfe geht räumlich plausibel von der Person in die Umgebung über; Licht, Kontrast und Detailwirkung von Person und Raum wirken wie in einer einzigen realen Aufnahme. ### 8.5. Inszenierung * Ruhige, konzentrierte Arbeitssituation ohne Kameralächeln oder gestellte Pose. * Haltung und Handlungen wirken natürlich, professionell und glaubwürdig.`
  - `B5 Beratungsgespräch am Schreibtisch` → Promptwert: `* Die Maklerperson erklärt einer Kundin oder einem Kunden die Lage einer Immobilie anhand eines Lageplans oder einer Umgebungskarte. * Gezeigt wird kein Grundriss und keine textlastige Broschürenseite als zentrales Gesprächsthema. * Der Lageplan beziehungsweise die Umgebungskarte liegt flach oder nur leicht angewinkelt auf dem Besprechungstisch. * Die Unterlage wird nicht hochgehalten und nicht zur Kamera präsentiert. * Die Maklerperson zeigt von ihrer gegenüberliegenden oder leicht seitlich versetzten Tischposition mit einem Stift oder Zeigefinger auf einen konkreten Punkt oder Bereich im Lageplan beziehungsweise auf der Umgebungskarte, zum Beispiel den Objektstandort oder eine relevante Lagebeziehung. * Die zeigende Geste wirkt locker, funktional und anatomisch korrekt. Die Hand verdeckt den besprochenen Bereich nicht unnötig. * Die zweite Hand liegt entspannt auf dem Tisch oder stabilisiert die Unterlage auf natürliche Weise. * Die Maklerperson bleibt mit der Erklärung sichtbar bei der Unterlage verankert, richtet den Blick im dargestellten Moment jedoch zur Kundin oder zum Kunden. * Die Kundin oder der Kunde verfolgt die Erklärung als reale Gesprächspartnerin beziehungsweise realer Gesprächspartner innerhalb der Beratungssituation. * Die Maklerperson weist realistische erwachsene Körperproportionen auf: normal große Kopfform im Verhältnis zu Schultern und Oberkörper, kein „Big-Head“- oder „Bobblehead“-Effekt. * Die Unterlage wirkt hochwertig, neutral und markenfrei. Darauf enthaltene Texte, Logos, Adressen und persönliche Daten sind nicht lesbar. * Keine dominante Neubau-, Bauträger- oder Hochglanz-Verkaufsästhetik. ### 8.3. Bildaufbau, Perspektive und Licht * Natürliche, halbnahe Perspektive auf Augenhöhe am Besprechungstisch. Gesicht, Gesprächsgeste und Lageplan beziehungsweise Umgebungskarte sind klar erkennbar. * Die Kamera befindet sich leicht seitlich zur Beratungssituation und nicht exakt frontal vor der Maklerperson. * Die Bildkomposition wirkt wie ein beiläufig beobachteter Augenblick innerhalb eines echten Beratungsgesprächs und nicht wie eine gestellte Präsentation. * Die Maklerperson ist nicht vollständig frontal zur Kamera ausgerichtet. Ihr Oberkörper orientiert sich natürlich zum Tisch, zur Unterlage und zur Gesprächssituation. * Die Kamera schaut knapp seitlich an der Kundin oder dem Kunden vorbei. * Die Kundin oder der Kunde ist seitlich angeschnitten und klar als Gesprächspartnerin beziehungsweise Gesprächspartner erkennbar, ohne die Maklerperson zu dominieren. * Die Kundin oder der Kunde darf sichtbar mehr sein als nur ein minimales Randfragment, nimmt aber weiterhin eine untergeordnete Nebenrolle ein und verdeckt weder die Unterlage noch die Hände der Maklerperson. * Die Tischkante bleibt im unteren Bildbereich; der Oberkörper der Maklerperson bleibt ausreichend sichtbar, sodass die Person weder abgesunken noch zu tief hinter dem Tisch wirkt. * Weiches, natürliches Tageslicht erzeugt eine helle, ruhige und vertrauensvolle Büroatmosphäre. * Ausgewogene, realistische Belichtung ohne dramatische Lichtsetzung, übermäßigen Hochglanz oder künstlich leuchtende Haut. * Die Farbgebung ist natürlich, dezent und professionell, mit zurückhaltenden neutralen Farbtönen. ### 8.4. Schärfe, Tiefenwirkung und Integration * Fotografiert mit einer Fujifilm X-T5 und einem 35-mm-Objektiv, entsprechend etwa 53 mm KB-äquivalent, bei f/4 bis f/5.6, 1/125 s und ISO 400. * Der optische Fokus liegt auf der Maklerperson, ihrer natürlichen Interaktion und dem besprochenen Bereich des Lageplans beziehungsweise der Umgebungskarte. * Gesicht, Blickrichtung, zeigende Hand und relevanter Bereich der Unterlage bleiben ausreichend klar erkennbar. * Die Kundin oder der Kunde darf leicht unscharf erscheinen, bleibt aber als natürliche Gesprächsperson erkennbar. * Dezente, optisch glaubwürdige Tiefenunschärfe mit weichen und natürlichen Übergängen. * Keine künstliche Freistellung, keine übertriebene Hintergrundunschärfe und keine unnatürlich scharfen Konturen. * Hände, Finger, Arme, Gesicht und Körper sind vollständig, anatomisch korrekt und perspektivisch schlüssig dargestellt. * Keine zusätzlichen Finger, verschmolzenen Hände, verdrehten Gelenke oder unnatürlichen Armhaltungen. * Personen, Möbel, Unterlage, Tischkante und Hintergrund sind räumlich und perspektivisch glaubwürdig miteinander verbunden. ### 8.5. Inszenierung * Authentischer, unbeobachtet wirkender Moment mitten in einer Beratung: freundlich, kompetent und professionell, aber nicht werblich inszeniert. * Dargestellt ist exakt der Augenblick, in dem die Maklerperson einen konkreten Punkt oder Bereich im Lageplan beziehungsweise auf der Umgebungskarte erklärt, mit einem Stift oder Zeigefinger darauf verweist und die Kundin oder den Kunden dabei direkt ansieht. * Die Augen der Maklerperson sind eindeutig auf die Kundin oder den Kunden gerichtet. * Auch die Kundin oder der Kunde richtet die Aufmerksamkeit in diesem Moment auf die Maklerperson. * Zwischen den Personen besteht im dargestellten Augenblick ein natürlicher direkter Blickkontakt. * Die zeigende Hand bleibt bei der Unterlage, während Kopf und Blick der Maklerperson zur Kundin oder zum Kunden gewandt sind; diese Kombination wirkt wie eine echte Erklärung mitten im Gespräch. * Die Maklerperson befindet sich sichtbar mitten im Sprechen: Der Mund ist leicht geöffnet und zeigt eine dezente, natürliche Gesprächsmimik. * Die Augenlider und die gesamte Augenpartie wirken entspannt. Stirn, Kiefer und übrige Gesichtsmuskulatur bleiben locker. * Die Körperhaltung wirkt ruhig, funktional und leicht asymmetrisch, wie in einer echten Beratungssituation. * Aufrechte, entspannte Sitzhaltung in natürlicher Sitzhöhe; die Maklerperson sitzt weder abgesunken noch zu tief hinter dem Tisch. * Die Szene vermittelt persönliche, fachliche Erklärung auf Augenhöhe, während der Lageplan beziehungsweise die Umgebungskarte als sichtbarer Gesprächsgegenstand präsent bleibt. * Kein Blick in die Kamera. * Kein starrer oder durchdringender Blick, keine weit geöffneten Augen und keine angespannte Mimik. * Kein bewusstes oder ausgeprägtes Lächeln, keine demonstrativ hochgehaltene Unterlage und keine frontale Verkaufspräsentation. * Kein typisches Stockfoto-Posing, keine einstudierte Zeigegeste, keine künstlich perfekte Symmetrie und keine bewusst für die Kamera eingenommene Pose.`
  - `B6 Daumen hoch im Büro` → Promptwert: `* Die Maklerperson zeigt frontal eine positive Daumen-hoch-Geste. * Keine weiteren Personen im Bild. * Hintergrund weich unscharf mit dezenter Bokeh-Wirkung. * Gesicht, Hand und Finger sind klar und anatomisch korrekt dargestellt. * Bürohintergrund mit Glaswänden, Schreibtischen und Stühlen. ### 8.3. Bildaufbau, Perspektive und Licht * Halbnahe Frontansicht. Die Maklerperson steht leicht links der Bildmitte und blickt direkt in die Kamera. * Der rechte Arm ist nach vorn gestreckt; die Daumen-hoch-Geste wirkt präsent, aber natürlich. * Hintergrund weich unscharf mit dezenter Bokeh-Wirkung. * Weiches Tageslicht mit dezenten Reflexionen auf Glasflächen. * Lichtrichtung und Eigenschatten auf der Maklerperson entsprechen dem Umgebungslicht. ### 8.4. Schärfe, Tiefenwirkung und Integration * Fujifilm X-T5 mit 35-mm-Objektiv, ca. 53 mm KB-äquivalent, f/4, 1/125 s, ISO 400. * Optischer Fokus auf Gesicht und Daumen. Leichte perspektivisch korrekte Betonung der ausgestreckten Hand ohne Verzeichnung. * Bürohintergrund bleibt dezent erkennbar. ### 8.5. Inszenierung * Freundlicher, selbstbewusster Ausdruck mit natürlichem Lächeln. * Geste und Körperhaltung wirken locker, glaubwürdig und nicht übertrieben werblich.`
  - `B7 Maklerperson erklärt ernst ins Off` → Promptwert: `* Die Maklerperson erklärt einer Person gegenüber einen Sachverhalt. * Blickkontakt und Gesten vermitteln Aufmerksamkeit, Kompetenz und Klarheit. * Keine weiteren sichtbaren Personen. * Kein Text, keine Logos oder Wasserzeichen. ### 8.3. Bildaufbau, Perspektive und Licht * Halbnahe Aufnahme auf Augenhöhe. Die Maklerperson sitzt leicht rechts der Bildmitte und schaut nach links. * Weiches, natürliches Bürolicht modelliert Gesicht und Hände ohne harte Schatten. * Beide Hände sind in einer erklärenden Geste nach vorn gerichtet. ### 8.4. Schärfe, Tiefenwirkung und Integration * Fujifilm X-T5 mit 35-mm-Objektiv, ca. 53 mm KB-äquivalent, f/4, 1/125 s, ISO 400. * Optischer Fokus auf Augen, Gesicht und Gesten. * Hintergrund weich unscharf mit dezenten Bokeh-Lichtern, Büro bleibt erkennbar. ### 8.5. Inszenierung * Konzentrierte Beratungs- oder Verhandlungssituation, ernst und engagiert, jedoch nicht angespannt oder abweisend. * Die unsichtbare Gesprächsperson sitzt links im Off. Kein Blick in die Kamera.`
  - `B8 Maklerperson hinter dem Notebook mit Daumen hoch` → Promptwert: `* Die Maklerperson sitzt in einem hellen, sparsam eingerichteten Immobilienmaklerbüro frontal hinter einem großen Laptop * Maklerperson zeigt mit ihrer anatomisch rechten Hand die "Daumen hoch"-Geste. * Ein Smartphone, eine Mappe und ein paar Unterlagen liegen neben dem Laptop. * Geräte und Einrichtung sind neutral und markenfrei. * Keine weiteren Personen, kein Text, keine Logos oder Wasserzeichen. ### 8.3. Bildaufbau, Perspektive und Licht * Die Maklerperson blickt direkt in die Kamera. * Die Maklerperson wird aus einer natürlichen, unverzerrten Perspektive im hellen Immobilienbüro dargestellt. * Die Person wirkt glaubwürdig in die Arbeitsumgebung eingebunden und nicht künstlich freigestellt. * Lichtrichtung, Farbtemperatur, Schlagschatten und Eigenschatten der Person stimmen mit der Büroeinrichtung und dem durch die Fenster einfallenden Licht überein. * Ein konkreter Blick aus den Fenstern ist wegen leichter Überstrahlung nicht möglich, * Die anatomisch rechte hand aus der Sicht der Maklerperson ist aus Sicht des Betrachters links im Bild. ### 8.4. Schärfe, Tiefenwirkung und Integration * Fujifilm X-T5 mit 35-mm-Objektiv, ca. 53 mm KB-äquivalent, f/4, 1/125 s, ISO 400. * Optischer Fokus auf Gesicht und Geste. Der Laptop im Vordergrund bleibt glaubwürdig integriert. * Hintergrund weich unscharf, keine künstliche Freistellung. ### 8.5. Inszenierung * Freundlicher, selbstbewusster Ausdruck mit natürlichem, dezentem Lächeln mit geschlossenem Mund. * Kein übertriebenes Werbelächeln, kein demonstratives Lachen. * Die Pose wirkt positiv und professionell, nicht wie übertriebene Werbung. * Körperhaltung und Position der Hand wirken entspannt und anatomisch korrekt.`
  - `B9 Freundliche Erklärung rechts ins Off` → Promptwert: `* Die Maklerperson spricht sehr freundlich mit einer nicht sichtbaren Person rechts im Bild. * Blickrichtung und Körperhaltung sind klar auf diese Person ausgerichtet. * Keine weiteren sichtbaren Personen. * Kein Text, keine Logos oder Wasserzeichen. ### 8.3. Bildaufbau, Perspektive und Licht * Halbtotale Aufnahme auf Augenhöhe. Die Maklerperson sitzt leicht links der Bildmitte und schaut rechts an der Kamera vorbei. * Weiches Tages- und Umgebungslicht sorgt für natürliche Hauttöne und klare Augen. * Eine Hand ist in einer offenen, erklärenden Geste sichtbar, die andere Hand liegt ruhig auf dem Tisch. ### 8.4. Schärfe, Tiefenwirkung und Integration * Fujifilm X-T5, Halbtotale, f/4, 1/125 s, ISO 400. * Optischer Fokus auf Gesicht, Augen und Handgesten der Maklerperson. * Moderner, reduzierter Bürohintergrund mit geringer Tiefenschärfe und dezentem Bokeh. ### 8.5. Inszenierung * Freundliche, engagierte Beratungssituation. * Kein! direkter Kamerablick. * Die Maklerperson schaut zur Person die am rechten Bildrand im Off sitzt. * Ausdruck und Gesten wirken lebendig, aber nicht übertrieben oder stockfotoartig.`
  - `B10 Erklärung in einer Seminarsituation` → Promptwert: `* Die Maklerperson erklärt stehend einen Inhalt und trägt lockere Business-Casual-Kleidung mit langen Ärmeln. * Ort ist ein kleiner, heller Büro- oder Seminarraum mit großen Fenstern, Vorhang oder Jalousien. * Hintergrund bewusst weich unscharf, Sprecherperson scharf fokussiert. * Kein sichtbarer Präsentationstext, keine Logos oder Wasserzeichen. ### 8.3. Bildaufbau, Perspektive und Licht * Leicht niedrige Perspektive. Die Maklerperson steht links im Vordergrund und schaut rechts an der Kamera vorbei leicht nach oben. * Das angesprochene Whiteboard oder die Leinwand liegt außerhalb des Bildes. * Weiches Fensterlicht von rechts; der Raum darf für die Präsentation leicht abgedunkelt sein. ### 8.4. Schärfe, Tiefenwirkung und Integration * Fujifilm X-T5 mit 23-mm-Objektiv, ca. 35 mm KB-äquivalent, f/4, 1/125 s, ISO 500. * Optischer Fokus auf die Maklerperson; geöffnete Hände und Gesicht bleiben klar erkennbar. * Sitzende Teilnehmende erscheinen nur sehr unscharf im Hintergrund und blicken in dieselbe Richtung. ### 8.5. Inszenierung * Professionelle Workshop- oder Meeting-Atmosphäre mit freundlicher, engagierter Sprecherpose. * Dynamische Gesten wirken natürlich und nicht theatralisch.`
  - `B11 Portrait im Büroflur mit Logo` → Promptwert: `* Modernes Portrait in einem hellen Bürogang. * Das beigefügte Logo erscheint im Hintergrund als leicht unscharfes, physisch montiertes 3D-Wandlogo. * Keine weiteren Personen, Bildunterschriften oder sonstigen lesbaren Texte. ### 8.3. Bildaufbau, Perspektive und Licht * Die Maklerperson steht leicht seitlich der Bildmitte in einem hellen Büroflur. * Die Komposition darf gespiegelt oder variiert werden, sodass sich das Logo auf einer geeigneten Wandfläche links oder rechts im Bild befinden kann. * Arme selbstbewusst verschränkt, direkter Blick in die Kamera. * Die Maklerperson ist mindestens bis zu den Ellbogen und Unterarmen im Bild sichtbar. * Der Büroflur besitzt eine glaubwürdige räumliche Tiefe mit hellen Wandflächen, Glasflächen und dezenten Einrichtungselementen. * Das Logo kann auf einer größeren Wand oder einem kleineren, gut sichtbaren Wandabschnitt montiert sein. * Der unmittelbare Wandbereich des Logos kann unmöbliert oder möbliert gestaltet sein; beide Ausführungen sind gleichwertig und keine davon ist als Standard zu bevorzugen. * Einrichtungselemente dürfen die Wandfläche optisch strukturieren, das Logo jedoch nicht wesentlich verdecken. * Die Perspektive des Logos folgt derselben Wandebene und denselben Fluchtpunkten wie die sichtbaren Architektur- und Raumkanten. * Die Kamera ist waagerecht ausgerichtet; vertikale Gebäudekanten bleiben vertikal. * Weiches Tageslicht auf Gesicht und Kleidung; Glasflächen zeigen nur dezente Reflexionen. ### 8.4. Logo-Geometrie, Größe und Wandintegration * Das beigefügte Logo wird als unverändertes grafisches Referenzobjekt verwendet und nicht als Schriftzug neu erzeugt oder interpretiert. * Buchstabenformen, Konturen, Strichstärken, Farben, Abstände und relative Größen werden originalgetreu übernommen. * In seiner eigenen frontalen Ebene behält das Logo exakt das ursprüngliche Seitenverhältnis und alle internen Proportionen. * Die sichtbare perspektivische Verjüngung entsteht ausschließlich durch die räumliche Ausrichtung des gesamten Logos auf der Wand. * Das Logo bleibt gegenüber der Person ein untergeordnetes Bildelement. * Das Logo besitzt eine dünne, einheitliche 3D-Materialtiefe von ungefähr 5 % seiner sichtbaren Höhe. * Die Seitenflächen bleiben schmal und zurückhaltend; das Logo darf nicht wie ein massiver Block, ein tiefes Gehäuse oder eine Leuchtreklame wirken. * Dezente, wandnahe Kontaktschatten und gleichmäßige Seitenflächen verbinden das Logo glaubwürdig mit der Wand. ### 8.5. Schärfe, Tiefenwirkung und Integration * Fujifilm X-T5 mit 35-mm-Objektiv, ca. 53 mm KB-äquivalent, f/4, 1/125 s, ISO 400. * Optischer Fokus auf Gesicht und Augen, Hintergrund weich unscharf. * Glaswände, helle Flächen und die Tiefe des Büroflurs bleiben erkennbar. * Das Wandlogo erscheint leicht unscharf, seine Silhouette, Proportionen, Größe und räumliche Ausrichtung bleiben jedoch eindeutig erkennbar. ### 8.6. Inszenierung * Ruhiger, freundlicher und professioneller Gesichtsausdruck. * Die Haltung wirkt souverän, aber nicht streng oder distanziert.`
  - `B11.V2 Portrait im Büroflur mit Logo an Stirnwand` → Promptwert: `* Modernes Portrait in einem hellen Bürogang mit glaubwürdiger räumlicher Tiefe, hellen Wandflächen, Glasflächen und dezenten Einrichtungselementen. * Die Maklerperson steht leicht seitlich der Bildmitte auf einer Drittellinie, Arme selbstbewusst verschränkt, direkter Blick in die Kamera. Mindestens bis Ellbogen und Unterarme sichtbar. * Ruhiger, freundlicher und professioneller Gesichtsausdruck; souverän, aber nicht streng oder distanziert. * Keine weiteren Personen und keine lesbaren Texte im Bild. ### 8.3. Kamera und Licht * Fujifilm X-T5 mit 35-mm-Objektiv, ca. 53 mm KB-äquivalent, f/4, 1/125 s, ISO 400. * Kamera waagerecht auf Augenhöhe, vertikale Gebäudekanten bleiben vertikal. * Optischer Fokus auf Gesicht und Augen, Hintergrund weich unscharf. * Weiches Tageslicht auf Gesicht und Kleidung; Glasflächen zeigen nur dezente Reflexionen. ### 8.4. Logo an der Stirnwand * Hinter der Maklerperson schließt der Flur mit einer geraden Stirnwand ab, die nahezu parallel zur Bildebene steht. * Auf dieser Stirnwand ist das beigefügte Logo als physisches 3D-Wandlogo montiert, seitlich versetzt zur Person, sodass es frei sichtbar bleibt. * Das Logo wird als unverändertes grafisches Referenzobjekt eingesetzt und nicht neu gezeichnet, nachgebaut, gespiegelt oder als Schriftzug interpretiert. * Das Logo erscheint frontal und unverzerrt, ohne perspektivische Verjüngung oder Schrägstellung. * Die Logohöhe beträgt etwa 10 % der Bildhöhe; das Logo bleibt gegenüber der Person ein untergeordnetes Bildelement. * Materialtiefe ungefähr 5 % der sichtbaren Logohöhe, mit schmalen, gleichmäßigen Seitenflächen und einem dezenten Kontaktschatten zur Wand. Kein massiver Block, kein Gehäuse, keine Leuchtreklame. * Das Logo liegt außerhalb der Fokusebene und erscheint leicht unscharf; Silhouette und Proportionen bleiben eindeutig erkennbar.`
  - `B12 Ganzkörperportrait im Büroflur mit Wandlogo` → Promptwert: `* Ort ist ein moderner Büroflur oder Konferenzbereich. * Ein unscharfes Wandlogo erscheint nur bei hochgeladener Logodatei. * Ohne Logodatei bleibt die Wand neutral und ohne erfundenes Logo. * Keine weiteren Personen oder lesbaren Texte. ### 8.3. Bildaufbau, Perspektive und Licht * Die Maklerperson steht links im Bild vor einer dunklen, in die Tiefe verlaufenden Wand. * Direkter Blick in die Kamera, lockere und professionelle Körperhaltung. * Ein heller Bürobereich links im Hintergrund schafft natürlichen Kontrast. ### 8.4. Schärfe, Tiefenwirkung und Integration * Fujifilm X-T5 mit 23-mm-Objektiv, ca. 35 mm KB-äquivalent, f/4 bis f/5.6, 1/125 s, ISO 500. * Die gesamte Person ist klar fokussiert und anatomisch korrekt dargestellt. * Starke, natürliche Raumtiefe mit weichem Hintergrund und dezenten Bokeh-Lichtern. ### 8.5. Inszenierung * Freundliches, selbstbewusstes Lächeln ohne übertriebene Werbewirkung. * Die Pose wirkt ruhig, offen und glaubwürdig.`
  - `B13 Schulterzucken am Schreibtisch` → Promptwert: `* Die Maklerperson sitzt am Schreibtisch und zeigt eine dezente professionelle Fragegeste: leichte Schulterhebung, locker seitlich geöffnete Unterarme und nach oben gerichtete Handflächen. * Auf dem Schreibtisch befinden sich Laptop, Tablet, Notizbuch, Stiftehalter und neutrale Unterlagen in geordneter, zurückhaltender Anordnung; die Objekte bleiben dem Hauptmotiv untergeordnet und verdecken weder Oberkörper noch Handgeste. * Oberkörper und beide Unterarme bleiben sichtbar in die Szene eingebunden; Kopf, Hals, Schultergürtel und Torso erscheinen anatomisch proportional und weder verkürzt noch überbreit. * Beide Hände und alle Finger sind vollständig sichtbar und anatomisch korrekt dargestellt. * Keine weiteren Personen, Logos oder Wasserzeichen; keine sonstigen lesbaren Texte außer der in Abschnitt 11 geforderten Bildbeschriftung rechts unten. ### 8.3. Bildaufbau, Perspektive und Licht * Ruhige, leicht versetzte Ansicht der sitzenden Maklerperson auf Augenhöhe. * Großzügige halbnahe Einstellung mit vollständiger Schulterbreite, sichtbar eingebundenem Oberkörper bis etwa zum mittleren Bauchbereich, beiden Unterarmen und ausreichend Schreibtischfläche. * Die Tischkante bleibt im unteren Bildbereich und darf den Oberkörper nicht so hoch verdecken, dass die Person zu tief sitzend oder der Torso verkürzt wirkt. * Kopf, Hals, Schultern und Oberkörper bilden im Bild eine ausgewogene Größen- und Längenrelation; weder Kopf noch Brust- und Schulterbereich dominieren die Personenwirkung. * Direkter Blick in die Kamera; beide Hände bleiben mit etwas Abstand zu den Bildrändern vollständig im Bild. * Die Person wird bevorzugt leicht außerhalb der exakten Bildmitte platziert. * Das Gesicht liegt gleichmäßig in neutralem Fenster-Tageslicht, ohne warme oder kühle Farbstiche auf der Haut. ### 8.4. Schärfe, Tiefenwirkung und Integration * Fujifilm X-T5 mit 35-mm-Objektiv, ca. 53 mm KB-äquivalent, f/4 bis f/5.6, 1/125 s, ISO 400. * Fokus auf dem Gesicht; die Schärfentiefe ist ausreichend, damit Schultern und beide Hände ebenfalls klar und natürlich scharf erscheinen. * Schreibtisch und Büro bleiben dezent erkennbar, mit leichter Tiefenwirkung und ohne künstlichen Freistellungs- oder Fotomontage-Look. ### 8.5. Inszenierung * Aufrechte, entspannte Sitzhaltung in natürlicher Sitzhöhe; die Person sitzt weder abgesunken noch zu tief hinter dem Schreibtisch. * Kopf und Oberkörper bleiben natürlich übereinander ausgerichtet, ohne Vorlehnen zur Kamera. * Ruhiger direkter Blick mit natürlicher, leicht fragender Mimik und neutralem bis höchstens minimal angedeutetem Lächeln. * Die leichte Schulterhebung und die offenen Handflächen bilden eine zusammenhängende, professionelle Fragegeste; nicht komisch, nicht übertrieben und nicht theatralisch.`
  - `B14 Offene Ansprache mit Freifläche links` → Promptwert: `* Die Maklerperson steht in einem hellen Büro- oder Empfangsbereich. * Sichtbare Elemente des Raums sind Glaswände, Holzflächen und einzelne dezente Pflanzen. * Die linke Bildhälfte bleibt als helle, ruhige Freifläche weitgehend offen und frei von Möbeln, Personen, auffälligen Pflanzen und sonstigen markanten Details. * Keine sichtbaren Logos und keine sonstigen lesbaren Texte außer der im aktuellen Masterprompt ausdrücklich geforderten Bildbeschriftung. ### 8.3. Bildaufbau, Perspektive und Licht * Halbnahe Aufnahme auf Augenhöhe in ruhiger, leicht versetzter Ansicht. * Die Maklerperson steht klar rechts im Bild, mit ausreichend Abstand zum rechten Rand, und blickt direkt in die Kamera. * Links bleibt ein großer, heller und visuell ruhiger Freiraum für Text oder Gestaltung. * Weiches, diffuses und neutral wirkendes Fenster-Tageslicht bestimmt die Szene. Das Gesicht ist gleichmäßig und natürlich ausgeleuchtet. Auf der linken Freifläche erscheinen keine sichtbaren direkten Sonnenstrahlen, Sonnenflecken oder projizierten Fensterrahmen- und Schattenmuster; die Fläche bleibt gleichmäßig hell und ruhig. ### 8.4. Schärfe, Tiefenwirkung und Integration * Fujifilm X-T5 mit 35-mm-Objektiv, ca. 53 mm KB-äquivalent, f/4, 1/125 s, ISO 400. * Optischer Fokus auf Gesicht und Augen; die vor dem Körper gehaltenen Hände bleiben ausreichend klar und natürlich scharf. * Der Hintergrund mit Glas, Holz und Pflanzen ist sanft unscharf, aber klar als moderner Büroraum erkennbar. Die Schärfe geht von der Maklerperson kontinuierlich und räumlich plausibel in den Hintergrund über; an Haaren, Schultern und Kleidung entsteht keine harte optische Freistellungskante. Licht, Kontrast und dezente Umgebungsreflexe auf der Person entsprechen unmittelbar dem umgebenden Raum, sodass Person und Büro wie in einer einzigen realen Aufnahme wirken. ### 8.5. Inszenierung * Freundlicher, selbstbewusster und ruhiger Ausdruck mit natürlicher, nahbarer Ausstrahlung. * Natürliches, zurückhaltendes Lächeln; weder breites werbliches Grinsen noch zu ernste oder kühle Wirkung. * Offene, entspannte Körperhaltung; die Hände werden locker vor dem Körper gehalten, ohne starre oder künstliche Pose.`
  - `B15 Zollstock-Durchblick 1 (Büro)` → Promptwert: `* Die Maklerperson steht in einem hellen Büro- oder Empfangsbereich und hält einen faltbaren Holz-Zollstock so vor sich, dass er klar die Form eines Hauses bildet. * Sie blickt durch die Hausform direkt in die Kamera; das Gesicht ist vollständig innerhalb der Hausform sichtbar. * Zwischen Kopf und Zollstock bleibt auf allen Seiten klar erkennbarer Innenabstand: oberhalb der Haare, seitlich an beiden Wangen und besonders zwischen Kinn und der unteren waagerechten Zollstockkante. * Im sichtbaren Umfeld erscheinen ein moderner Büro- oder Empfangsbereich mit Glaswänden, Holzdetails und dezenten Pflanzen. * Die Bildidee steht klar für Immobilie, Hausbau oder Renovierung. * Keine weiteren Personen, Logos, Texte oder Wasserzeichen. ### 8.3. Bildaufbau, Perspektive und räumliche Staffelung * Ruhige frontale Ansicht auf Augenhöhe mit direktem Blick in die Kamera. * Großzügige halbnahe Einstellung mit sichtbar eingebundenem Oberkörper, beiden Unterarmen und ausreichend freiem Raum um Person und Hausform. * Der Zollstock wird mit locker leicht ausgestreckten Armen in moderatem Abstand vor dem Oberkörper gehalten. Er steht sichtbar vor dem Gesicht, aber nicht so nah am Kopf, dass der Eindruck entsteht, die Person stecke den Kopf durch den Zollstock. * Die Hausform soll nicht eng um das Gesicht sitzen, sondern eher etwas großzügiger dimensioniert sein. Der Kopf wirkt klar innerhalb der Form und nicht an ihre Innenkanten gedrängt. * Die untere horizontale Zollstockkante sitzt klar unterhalb des Kinns, sodass Halsansatz und ein kleiner Bereich des oberen Brust-/Kragenbereichs sichtbar zwischen Kinn und Zollstock bleiben. * Beide Hände bleiben ungefähr auf derselben räumlichen Ebene. Sie dürfen leicht nach vorn kommen, aber nicht so weit, dass Hände oder Zollstock im Verhältnis zum Gesicht übergroß erscheinen. * Ziel ist eine glaubwürdige räumliche Staffelung: Zollstock und Hände leicht vor dem Körper, Gesicht klar dahinter, insgesamt wie eine echte Aufnahme statt wie eine erzwungene Vordergrund-Hintergrund-Konstruktion. ### 8.4. Schärfe, Tiefenwirkung und Integration * Fujifilm X-T5 mit 35-mm-Objektiv, ca. 53 mm KB-äquivalent, f/5.6, 1/125 s, ISO 200. * Gesicht, beide Hände und die Hausform des Zollstocks sind klar fokussiert. * Der Hintergrund zeigt eine dezente, realistische Tiefenunschärfe, bleibt jedoch eindeutig als realistisches Immobilienmaklerbüro erkennbar. Keine ausgestanzt wirkenden Konturen und kein künstlicher Smartphone-Portraitfilter. * Die Schärfe geht von der Person kontinuierlich und plausibel in den Hintergrund über; an Haaren, Schultern, Kleidung und Zollstock entstehen keine harten Freistellungskanten. Licht, Kontrast und Umgebungsreflexe auf Person, Händen und Zollstock wirken wie aus einer einzigen realen Aufnahme. ### 8.5. Inszenierung * Freundlicher, positiver und souveräner Ausdruck mit natürlicher, nicht überinszenierter Corporate-Wirkung. * Aufrechte, entspannte Körperhaltung mit ruhiger, kontrollierter Körpersprache. * Beide Hände halten den Zollstock anatomisch und konstruktiv plausibel; alle Finger sind vollständig sichtbar und natürlich dargestellt. * Die Hausform des Zollstocks wirkt sauber, stabil und klar lesbar. * Priorität in dieser Version: lieber etwas mehr Luft zwischen Gesicht und Zollstock als eine zu enge Rahmung. Grenzfälle, in denen Kopf oder Kinn zu nah an den Innenkanten sitzen, sollen vermieden werden.`
  - `B16 Beratungsgespräch over the shoulder` → Promptwert: `* Besprechungsbereich eines Immobilienmaklerbüros, die Einrichtung ist neutral, modern und markenfrei. * Ein Paar in den 40ern sitzt in einem Besprechungsraum hinter einem Tisch. * Die Maklerperson ist unscharf im Vordergrund und nur von hinten sichtbar; * Alle beteiligen sich am Gespräch über Immobilien, Planung, Kaufentscheidung oder Beratung. * Die Atmosphäre des Beratungsgesprächs ist freundlich, modern und kooperativ. * Natürliche Gesichtsausdrücke und eine offene Körperhaltung vermitteln Vertrauen. #### 8.3. Bildaufbau, Perspektive und Licht * Over-the-shoulder-Perspektive aus Sicht der Maklerperson. * Man schaut über eine Schluter der unscharf erkennbaren Maklerperson im Vordergrund; das Paar hinter dem Schreibtisch ist optisch klar fokussiert. * Natürliches Tageslicht von links erzeugt eine helle, freundliche Stimmung. #### 8.4. Schärfe, Tiefenwirkung und Integration * Fujifilm X-T5 mit 35-mm-Objektiv, ca. 53 mm KB-äquivalent, f/4, 1/125 s, ISO 400. * Optischer Fokus auf Gesichter und Reaktionen des Paares. * Vordergrundunschärfe und natürliche Raumtiefe, aber keine übertriebene Bokeh-Wirkung. * Keine Logos, Schrift, Wasserzeichen oder dominante Neubauästhetik. #### 8.5. Inszenierung * Ruhige, seriöse Beratung ohne Verkaufsdruck. * Beide Interessenten wirken offen, aufmerksam und freundlich und blicken zur Maklerperson.`
  - `B17 Daumen hoch vor unscharfem Bürohintergrund` → Promptwert: `* Die Maklerperson zeigt mit einem angewinkelten Arm eine klare Daumen-hoch-Geste. Die Hand bleibt nahe am Oberkörper und wird nicht weit in Richtung Kamera gestreckt. * Daumen und Hand sind vollständig sichtbar und anatomisch plausibel dargestellt. * Der helle Bürohintergrund vermittelt eine moderne, professionelle Arbeitsatmosphäre. * Hintergrundpersonen bleiben anonym, unauffällig und klar untergeordnet. * Materialien sind neutral und markenfrei; keine Wasserzeichen. ### 8.3. Bildaufbau, Perspektive und Licht * Großzügige halbnahe Aufnahme auf Augenhöhe. Kopf, vollständige Schulterbreite und der Oberkörper bis ungefähr zur Taille sind sichtbar; um die Person bleibt deutlich erkennbare Büro-Umgebung, sodass keine enge porträthafte Wirkung entsteht. * Die Maklerperson befindet sich leicht rechts der exakten Bildmitte. Der Oberkörper ist dezent aus der strengen Frontalachse gedreht, während der Kopf für den direkten Blick zur Kamera ausgerichtet bleibt. * Die Daumen-hoch-Geste bleibt klar innerhalb der Bildfläche und ungefähr auf der räumlichen Tiefenebene des Oberkörpers, sodass die Hand perspektivisch nicht übergroß wirkt. * Weiches, diffuses Fenster-Tageslicht bestimmt die Szene. Das Gesicht ist gleichmäßig und natürlich ausgeleuchtet, ohne auffällige warme oder kühle Farbstiche auf der Haut. ### 8.4. Schärfe, Tiefenwirkung und Integration * Fujifilm X-T5 mit 35-mm-Objektiv, ca. 53 mm KB-äquivalent, f/4, 1/125 s, ISO 400. * Primärer optischer Fokus auf dem Gesicht; die Schärfentiefe reicht aus, damit Daumen und Hand ebenfalls klar und natürlich scharf erscheinen. * Der Hintergrund ist nur leicht bis moderat unscharf mit sehr dezenter Bokeh-Wirkung; Raumstruktur, Arbeitsbereiche und Hintergrundpersonen bleiben als Büro erkennbar. ### 8.5. Inszenierung * Freundlicher, selbstbewusster und natürlich positiver Ausdruck mit nahbarer, lebendiger Ausstrahlung. * Natürliches Lächeln kleiner bis mittlerer Intensität mit leichter individueller Asymmetrie; die Zähne können dezent sichtbar sein, ohne breites oder stark symmetrisches Werbelächeln. * Die Körpersprache wirkt locker, glaubwürdig und leicht spontan. Die Daumen-hoch-Geste liest sich wie eine kurze positive Bestätigung aus einem natürlichen Arbeitsmoment und nicht wie eine bewusst gehaltene Werbepose.`
  - `B18 Kollegengespräch im Besprechungsraum` → Promptwert: `* Die Maklerperson und eine Kollegin sitzen nebeneinander an einem weißen Besprechungstisch in einem modernen Glasbüro und arbeiten gemeinsam an einem konkreten Vorgang. Sie sind locker zueinander orientiert, ohne sich für die Kamera anzugleichen. * Die Kollegin ist eine Frau Mitte 40 mit einem durchschnittlichen, alltagsnahen Erscheinungsbild und individuellen, nicht idealisierten Gesichtszügen. Sie wirkt eindeutig wie eine reale, mit der Maklerperson vertraute Kollegin aus dem normalen Büroalltag und nicht wie ein professionelles Model, eine Influencerin, eine Schauspielerin oder ein für Werbung gecastetes Gesicht. * Die Kollegin ist gepflegt, aber erkennbar für einen gewöhnlichen Arbeitstag und nicht für ein Fotoshooting gestylt. Sie trägt eine schlichte einfarbige Bluse oder ein bürotaugliches Feinstrickoberteil ohne Sakko. Ihre unkomplizierte Alltagsfrisur fällt natürlich oder ist locker zurückgenommen, ohne salonartig gelegte Föhnwellen. Make-up ist nicht oder nur sehr dezent wahrnehmbar; natürliche Hauttextur und individuelle Gesichtswirkung bleiben erhalten. * Die Maklerperson hält ein Tablet auf Tisch- bis Oberkörperhöhe, richtet dessen Display zur Kollegin aus und zeigt während einer sachlichen Erklärung mit der freien Hand auf einen konkreten Bereich des Displays. * Festgehalten wird genau der kurze Moment, in dem die Kollegin einen einzelnen Stichpunkt notiert: Die Stiftspitze berührt sichtbar das Papier, und ihr Blick liegt eindeutig auf dem geöffneten Notizblock, nicht auf dem Tablet. Die Maklerperson spricht währenddessen weiter und blickt auf den erläuterten Tabletinhalt. Erklärung und Notiz beziehen sich erkennbar auf denselben Arbeitsvorgang. * Geräte und Materialien sind neutral, markenfrei und ohne lesbaren Text. ### 8.3. Bildaufbau, Perspektive und Licht * Großzügige halbweite Zweipersonenaufnahme auf Augenhöhe aus einer ruhigen, leicht seitlich versetzten Beobachterperspektive. Kopf, vollständige Schulterbreite, Unterarme und ausreichend Oberkörper beider Personen sind sichtbar; um die Gruppe bleiben erkennbare Büro- und Tischflächen. * Die Maklerperson bildet durch die erklärende Handlung das klare visuelle Hauptmotiv und sitzt leicht außerhalb der exakten Bildmitte auf einer Drittellinie. * Beide Personen sitzen auf derselben räumlichen Tiefenebene und erscheinen in einer vergleichbaren, natürlichen Größenwirkung. Die Kollegin bleibt vollständig mit sichtbarem Randabstand in die gemeinsame mittlere Bildzone eingebunden und wird weder als randnahe Figur noch als vergrößertes Vordergrundelement inszeniert. * Die Körperhaltungen sind funktional verschieden und nicht spiegelbildlich: Die Maklerperson ist leicht zum Tablet geneigt; die Kollegin sitzt etwas aufrechter und wendet nur Kopf und Unterarme ihrer Notiz zu. Beide behalten entspannte Schultern und einen kleinen, glaubwürdigen Arbeitsabstand. * Das Tablet ist zu den beiden Personen und nicht präsentierend zur Kamera ausgerichtet. Notizblock und Stift liegen unmittelbar vor der Kollegin. Wenige tatsächlich verwendete Unterlagen liegen leicht versetzt und beiläufig auf dem Tisch statt dekorativ oder geometrisch perfekt angeordnet. ### 8.4. Schärfe, Tiefenwirkung und Integration * Fujifilm X-T5 mit 35-mm-Objektiv, ca. 53 mm KB-äquivalent, f/5.6, 1/125 s, ISO 500. * Beide Gesichter und die gemeinsame Handlungszone aus Händen, Tablet, Stift und Notizblock liegen in einem zusammenhängenden, natürlich scharfen Fokusbereich. Die Maklerperson bleibt durch Komposition und Handlung das Hauptmotiv; die Kollegin wird weder porträthaft hervorgehoben noch künstlich weichgezeichnet. * Die unmittelbare Tischfläche und die Bürostruktur bleiben gut erkennbar; der Hintergrund geht nur leicht und kontinuierlich in eine sehr dezente Unschärfe über. Vordergrundobjekte bleiben visuell untergeordnet und bilden keine großen unscharfen Barrieren. * Glaswände, Spiegelungen und Bürostrukturen wirken dezent, räumlich plausibel und wie Bestandteile einer einzigen realen Aufnahme. ### 8.5. Inszenierung * Die Szene wirkt wie ein beiläufig beobachteter Arbeitsmoment mitten in einer echten internen Abstimmung und nicht wie eine arrangierte Präsentation oder ein Werbeshooting. Die Personen präsentieren weder sich selbst noch das Tablet zur Kamera. * Die Aufmerksamkeit ist bewusst asynchron verteilt: Die Maklerperson erklärt am Tablet, während die Kollegin den dazugehörigen Stichpunkt tatsächlich niederschreibt. Ihre Kopfneigung, Blickrichtung und Handbewegung ergeben sich ausschließlich aus dieser Notizhandlung. * Die Kollegin zeigt eine ruhige, individuelle Konzentration mit entspannter Mundpartie und beiläufig natürlicher Wirkung; weder ein standardisiertes Werbelächeln noch eine betont ernste Businesspose. Kein direkter Kamerablick. * Kleine Unterschiede in Sitzhaltung, Abstand, Handposition und Körperspannung bleiben erhalten. Die vertraute Zusammenarbeit ist erkennbar, wirkt jedoch weder choreografiert noch perfekt synchronisiert.`
  - `B19 Beratungsgespräch mit jungem Paar` → Promptwert: `* Die Maklerperson zeigt einem Paar auf einem Tablet konkrete Immobilieninhalte und erklärt diese gerade. * Das Paar besteht aus zwei gewöhnlich wirkenden Erwachsenen Mitte dreißig, wie reale Kundinnen und Kunden aus dem Alltag. * Beide Personen besitzen eine unspektakuläre, durchschnittliche Alltagserscheinung und wirken nicht nach klassischen Schönheits- oder Werbekriterien ausgewählt. * Die Personen unterscheiden sich deutlich in Gesichtsform, Körperbau, Frisur und persönlichem Stil. * Alle drei Personen besitzen klar voneinander unterscheidbare Identitäten. * Insbesondere der männliche Kunde unterscheidet sich auf den ersten Blick deutlich von der Maklerperson. * Maklerperson und männlicher Kunde unterscheiden sich deutlich in Gesichtsform, Haaransatz, Frisur, Haarfarbe, Körperbau und Gesichtsbehaarung. * Von der Maklerperson und dem männlichen Kunden trägt immer genau eine Person sichtbare Gesichtsbehaarung; die jeweils andere Person ist vollständig glatt rasiert. * Der männliche Kunde ist vollständig glatt rasiert. * Der männliche Kunde wirkt nicht wie ein Verwandter, Doppelgänger oder eine leicht veränderte Variante der Maklerperson. * Eine Person des Paares besitzt einen etwas weicheren oder kräftigeren durchschnittlichen Körperbau, die andere einen davon abweichenden normalen Körperbau. Keine einheitliche schlanke Lifestyle-Castingästhetik. * Die Gesichter zeigen individuelle, nicht idealisierte Konturen, leichte natürliche Asymmetrien und altersgemäße Merkmale. * Sichtbare Hautstruktur, feine Stirn- oder Augenlinien, dezente Augenringe, leichte Unterschiede im Hautton und kleine Hautmerkmale bleiben erhalten. * Eine Person trägt eine schlichte Alltagsbrille. Die andere trägt keine Brille und besitzt eine sichtbar andere Gesichtsform und Frisur. * Haare und Frisuren wirken gewöhnlich und unkompliziert, ohne professionelles Styling, perfekte Wellen oder salonartig inszenierte Form. * Beide wirken ordentlich und alltagstauglich, aber nicht für ein Fotoshooting geschminkt, frisiert oder gestylt. * Das Paar trägt unabhängig voneinander ausgewählte Alltagskleidung in unterschiedlichen Farben, Schnitten und Materialien. * Keine farblich abgestimmte Paarkleidung und keine ähnlichen Oberteile aus demselben Material. * Eine Person darf beispielsweise ein schlichtes Hemd, eine Strickjacke oder ein unauffälliges Freizeithemd tragen, die andere einen einfachen Pullover oder ein schlichtes Oberteil. * Das Paar sitzt mit etwas Abstand nebeneinander. Keine Person sitzt hinter der anderen. * Die beiden Kunden nehmen bewusst unterschiedliche Körperhaltungen ein: Eine Person lehnt sich leicht zum Tablet vor, während die andere etwas aufrechter sitzt. * Das Tablet steht im Querformat mit seiner Unterkante stabil auf dem Tisch und befindet sich mittig vor beiden Kunden. * Die Bildschirmmitte ist auf den räumlichen Mittelpunkt zwischen den beiden Kunden ausgerichtet. * Beide Personen besitzen aus ähnlich günstiger Entfernung eine vollständig freie und unverdeckte Sicht auf die gesamte Bildschirmfläche. * Die Maklerperson stabilisiert das Tablet bei Bedarf seitlich mit einer Hand und weist mit der anderen beiläufig auf einen konkreten Bereich des Bildschirms. * Hände, Arme, Köpfe und Körper verdecken weder den Bildschirm noch die Sichtlinie einer der beiden Personen. * Alle drei Personen betrachten eindeutig dieselbe Stelle auf dem Tabletbildschirm. * Das Paar verfolgt die Erklärung mit ruhiger, interessierter Alltagsmimik. Eine Person zeigt allenfalls ein schwaches, beiläufiges Lächeln mit geschlossenem Mund, während die andere neutral und konzentriert bleibt. * Die Reaktionen unterscheiden sich sichtbar und wirken weder synchron noch einstudiert. * Auf dem Tisch liegen nur wenige neutrale und markenfreie Unterlagen. Texte, Logos, Adressen und persönliche Daten darauf sind nicht lesbar. * Einrichtung und Materialien wirken seriös, funktional und markenfrei, ohne dominanten Neubau-, Bauträger- oder Hochglanzfokus. ### 8.3. Bildaufbau, Perspektive und Licht * Natürliche, halbnahe Besprechungsszene auf Augenhöhe an einem hellen Beratungstisch. * Die Maklerperson sitzt links und leicht seitlich versetzt im natürlichen Dreiviertelprofil. * Das Paar sitzt nebeneinander auf der gegenüberliegenden Tischseite. Beide sind als gleichwertige Gesprächsteilnehmende erkennbar. * Die Sitzpositionen bilden eine räumlich glaubwürdige Beratungssituation und keine symmetrisch für die Kamera arrangierte Dreiergruppe. * Zwischen den beiden Kunden bestehen leichte Unterschiede in Sitzabstand, Schulterhöhe, Kopfhaltung und Entfernung zum Tisch. * Nur eine Person lehnt sich leicht nach vorn. Die andere sitzt etwas aufrechter und betrachtet das Tablet aus einer entspannten Position. * Keine parallele Kopfneigung, keine identische Armhaltung und keine spiegelbildliche Paarpose. * Das Tablet steht mittig zwischen den beiden Kunden und nicht überwiegend vor einer einzelnen Person. * Die gesamte Bildschirmfläche ist frontal oder nahezu frontal zum Paar ausgerichtet. * Der Bildschirm ist ausdrücklich nicht zur Kamera gedreht. * Aus Sicht der Kamera sind ausschließlich oder überwiegend die Rückseite des Tablets und höchstens eine schmale Seitenkante sichtbar. * Der Bildschirminhalt ist für die Kamera nicht sichtbar oder nur aus einem sehr schrägen, unlesbaren Winkel angedeutet. * Die freie und ergonomisch richtige Sicht beider Kunden auf den Bildschirm hat Vorrang vor der Sichtbarkeit des Bildschirminhalts für die Kamera. * Beide Sichtlinien treffen ungehindert auf den Tabletbildschirm. Weder die Maklerperson noch das jeweils andere Mitglied des Paares blockiert die Sicht. * Die Kamera beobachtet die Szene leicht seitlich und aus einer unaufdringlichen Position. * Die Komposition wirkt wie ein beiläufig festgehaltener Augenblick in einer echten Beratung und nicht wie ein arrangiertes Gruppen- oder Werbefoto. * Ausschließlich weiches, natürliches Tageslicht aus den Fenstern beleuchtet die Szene. * Im sichtbaren Bildausschnitt befinden sich keine Deckenleuchten, Pendelleuchten, Stehleuchten, Tischleuchten oder dekorativen Hintergrundlampen. * Die Bürodecke und der Hintergrund zeigen keine sichtbaren Leuchtkörper, leuchtenden Lampenschirme oder künstlich erhellten Flächen. * Sämtliche künstlichen Lichtquellen sind ausgeschaltet. * Ausgewogene, realistische Belichtung ohne warmes Kunstlicht, dramatische Lichtsetzung, übermäßigen Hochglanz oder künstlich leuchtende Haut. * Die Farbgebung ist natürlich, zurückhaltend und professionell. ### 8.4. Schärfe, Tiefenwirkung und Integration * Fotografiert mit einer Fujifilm X-T5 und einem 35-mm-Objektiv, entsprechend etwa 53 mm KB-äquivalent, bei f/5.6, 1/125 s und ISO 500. * Der optische Fokus liegt auf dem Paar, der Maklerperson und ihrer gemeinsamen Interaktion am Tablet. * Alle drei Gesichter, die Blickrichtungen, die erklärende Handbewegung und die räumliche Position des Tablets bleiben ausreichend klar erkennbar. * Beide Kunden befinden sich in derselben ausreichenden Schärfeebene. Keine Person des Paares wird durch starke Tiefenunschärfe visuell benachteiligt. * Der Tabletbildschirm muss für die Kamera weder lesbar noch sichtbar sein. Seine geometrisch korrekte Ausrichtung zum Paar besitzt Vorrang. * Leichte, optisch glaubwürdige Tiefenunschärfe mit weichen und natürlichen Übergängen. * Keine künstliche Freistellung, keine übertriebene Hintergrundunschärfe und keine unnatürlich scharfen Konturen. * Die Blickrichtungen sind anatomisch und perspektivisch schlüssig: Die Augen aller drei Personen sind eindeutig auf denselben Bereich des Tabletbildschirms gerichtet. * Die Blickachsen beider Kunden enden sichtbar am Tablet und verlaufen weder am Gerät vorbei noch zur Maklerperson oder unbestimmt in den Raum. * Beide Personen sehen auf die Bildschirmseite und nicht auf die Rückseite oder eine Seitenkante des Tablets. * Hände, Finger, Arme, Gesichter und Körper sind vollständig, anatomisch korrekt und perspektivisch glaubwürdig dargestellt. * Keine zusätzlichen Finger, verschmolzenen Hände, verdrehten Gelenke, schwebenden Hände oder unnatürlichen Armhaltungen. * Tablet, Hände, Tischkante, Unterlagen, Personen und Hintergrund sind räumlich glaubwürdig miteinander verbunden. * Keine verzerrte Tabletform, keine fehlerhaften Kanten, keine unnatürlichen Spiegelungen und keine unmöglichen Betrachtungswinkel. ### 8.5. Inszenierung * Authentischer, unbeobachtet wirkender Moment mitten in einer offenen Beratung: sachlich, freundlich und kompetent, aber nicht werblich inszeniert. * Dargestellt ist exakt der Augenblick, in dem die Maklerperson einen konkreten Inhalt auf dem Tablet erklärt. * Das Tablet steht ruhig und stabil mittig vor dem Paar. Beide Personen können gleichzeitig und ohne gegenseitige Behinderung die gesamte Bildschirmfläche sehen. * Alle drei Personen betrachten eindeutig dieselbe Stelle auf dem Tabletbildschirm. * Kopf, Augen und Aufmerksamkeit der Maklerperson sind auf das Tablet gerichtet. Die Körperhaltung bleibt gleichzeitig offen zum Paar ausgerichtet. * Die Maklerperson befindet sich sichtbar mitten im Sprechen. Der Mund ist leicht geöffnet und zeigt eine dezente, natürliche Gesprächsmimik. * Die erklärende Handbewegung ist klein, funktional und beiläufig. * Das Tablet wird nicht frei wie ein Werbeprodukt hochgehalten und nicht zur Kamera präsentiert. * Das Paar reagiert mit zwei unterschiedlichen, zurückhaltenden Gesichtsausdrücken. * Eine Person zeigt allenfalls ein schwaches Lächeln mit geschlossenem Mund. Die andere bleibt neutral, aufmerksam und konzentriert. * Keine demonstrativ sichtbaren Zahnreihen. * Nur eine Person lehnt sich leicht zum Tablet vor. Die andere sitzt etwas zurückgelehnt.`
  - `B20 Geschäftlicher Handschlag` → Promptwert: `* Gezeigt wird ein glaubwürdiger geschäftlicher Handschlag als zentraler Handlungsmoment. * Der Handschlag erfolgt zwischen den rechten Händen beider Personen. * Der Händekontakt bildet das zentrale Vordergrundmotiv der Szene. * Die Maklerperson steht hinter dem Handschlag eine Tiefenebene weiter hinten im Bild. * Kopf, Schulterbereich und Oberkörper der Maklerperson bleiben vollständig sichtbar und natürlich integriert. * Die Maklerperson wirkt zufrieden, professionell und souverän, bleibt dem Handschlag visuell jedoch klar untergeordnet. * Die zweite Person bleibt fast vollständig außerhalb des Bildfelds. * Von ihr ist nur der von links kommende rechte Arm sichtbar; Kopf, Gesicht und Oberkörper bleiben vollständig außerhalb des Bildes. * Das helle Büro zeigt große Fenster, neutrale Farben und eine sachliche, hochwertige Business-Atmosphäre. * Keine weiteren sichtbaren Personen. * Materialien bleiben markenfrei; keine Logos, keine Schrift, keine Wasserzeichen. ### 8.3. Bildaufbau, Perspektive und Licht * Dynamische Nahaufnahme aus niedriger bis sehr niedriger Perspektive. * Die Kamera blickt am von links kommenden Ärmel bzw. Vorderarm der anderen Person vorbei. * Der rechte Arm der nicht sichtbaren Person tritt aus dem linken Vordergrund ins Bild ein und führt diagonal in die Szene hinein. * Der eigentliche Händekontakt ist davon klar getrennt und liegt weiter innen im Bild. * Der Händekontakt liegt im linken Mittelfeld des Bildes, deutlich vom linken Bildrand gelöst und nahe an der Bildmitte. * Der von links kommende Arm dient nur als visuelle Hinführung zum Händekontakt und bleibt ein untergeordnetes Vordergrundelement. * Der Handschlag selbst ist das eigentliche Vordergrundmotiv. * Die Maklerperson steht hinter dem Handschlag im Hintergrund und wird nicht als klassisches Portrait-Hauptmotiv inszeniert. * Die Bildkomposition führt den Blick zuerst zum Händekontakt, erst danach zur Maklerperson. * Weiches Tageslicht erzeugt eine helle, optimistische und natürliche Büroatmosphäre. ### 8.4. Schärfe, Tiefenwirkung und Integration * Fujifilm X-T5 mit 56-mm-Objektiv, ca. 85 mm KB-äquivalent, f/2.8 bis f/3.2, 1/320 s, ISO 400. * Einzelpunkt-Autofokus direkt auf den Händekontakt; Gesichts- und Augen-Autofokus sind deaktiviert. * Die Fokusebene liegt exakt auf den ineinandergreifenden Händen. * Der Händekontakt ist der eindeutig schärfste Bereich des gesamten Bildes und trägt die höchste Detailzeichnung sowie den höchsten Mikrokontrast. * Fingerkonturen, Hautstruktur, Knöchel und Kontaktstelle der Hände sind klar, präzise und fotografisch am deutlichsten ausgearbeitet. * Die Maklerperson befindet sich deutlich hinter der Fokusebene; ihr Gesicht liegt ungefähr 70 bis 100 cm hinter dem Händekontakt. * Das Gesicht der Maklerperson bleibt als Person und Ausdruck lesbar, jedoch ohne prägnante Portraitschärfe. * Augen, Wimpern, Bartstruktur, Hautporen und feine Gesichtsdetaillierung sind sichtbar weicher als Finger, Knöchel und Hautstruktur des Händekontakts. * Die Maklerperson darf nicht über hohe Gesichts- oder Augenschärfe wirken, sondern über Haltung, Silhouette, Blickrichtung und allgemeinen Gesichtsausdruck. * Gesicht und Augen dürfen zu keinem Zeitpunkt gleich scharf oder schärfer erscheinen als der Händekontakt. * Der Schärfeabstand muss visuell klar erkennbar sein: Der Händekontakt dominiert schärfeseitig eindeutig, das Gesicht bleibt bewusst eine Stufe weicher. * Der von links kommende Vorderarm liegt vor der Fokusebene und wird zum linken Bildrand hin zunehmend weicher. * Der Schärfeverlauf bleibt natürlich und eindeutig: weicher Vorderarm → klar dominanter Händekontakt → sichtbar weichere Maklerperson → weicher Hintergrund. * Die Maklerperson bleibt präsent, übernimmt jedoch weder den fotografischen Fokus noch die höchste Detailschärfe. * Hände, Finger und Kontakt wirken anatomisch korrekt, eindeutig und natürlich integriert. * Keine deformierten Finger, keine verschmolzenen Hände, keine zusätzlichen Finger und keine unklaren Kontaktflächen. ### 8.5. Inszenierung * Der Handschlag vermittelt Einigung, Vertrauen und erfolgreichen Abschluss. * Die Maklerperson blickt freundlich zur nicht sichtbaren zweiten Person. * Freundlicher, professioneller und souveräner Ausdruck; kein übertriebenes Lächeln. * Der Handschlag bleibt die wichtigste erzählerische Handlung der Szene. * Die Gesamtwirkung bleibt hochwertig, realistisch und glaubwürdig fotografisch. * Keine künstliche Portraitwirkung und keine übertriebene Freistellung der Maklerperson. * Fotografische Schärfepriorität: Händekontakt zuerst, Maklerperson zweitrangig, linker Vorderarm nur als weiche Hinführung.`
  - `B21 Erfolgreicher Abschluss im Meeting` → Promptwert: `* Der Handschlag bildet den Mittelpunkt und steht für Einigung oder erfolgreichen Abschluss. * Auf dem Tisch liegen Laptop, neutrale Unterlagen, Diagramme, Stifte und eine Tasse. * Ort ist ein heller, moderner Besprechungsraum mit Glasflächen und neutralen Wänden. * Keine Logos, lesbaren Texte oder Wasserzeichen. ### 8.3. Bildaufbau, Perspektive und Licht * Halbweite Aufnahme von vier Geschäftspersonen an einem Besprechungstisch. * Die Maklerperson gibt einer anderen Person über den Tisch hinweg die Hand. * Natürliches Tageslicht und weiche Innenraumaufhellung schaffen eine helle, vertrauensvolle Stimmung. ### 8.4. Schärfe, Tiefenwirkung und Integration * Fujifilm X-T5 mit 23-mm-Objektiv, ca. 35 mm KB-äquivalent, f/5.6, 1/125 s, ISO 500. * Optischer Fokus auf Handschlag und Gesichter; alle Beteiligten bleiben ausreichend erkennbar. * Raum, Tisch und Glasflächen besitzen eine natürliche, dezente Tiefenwirkung. ### 8.5. Inszenierung * Glaubwürdiger Abschluss eines Meetings ohne künstliche Werbeinszenierung. * Die übrigen Personen beobachten freundlich und entspannt mit offener Körpersprache.`
  - `B22 Vertragsunterzeichnung beim Notar` → Promptwert: `* Eine Person des Kundenpaares unterschreibt einen Vertrag mit einem hochwertigen Stift. * Die Maklerperson sitzt seitlich oder gegenüber und wirkt unterstützend. * Die Notarin oder der Notar begleitet oder erklärt die Unterzeichnung dezent. * Auf dem Tisch liegen Vertragsunterlagen, Mappe, Schreibutensilien sowie optional Laptop oder Notizblock. * Keine Logos, echten Namen, lesbaren Texte, Vertragsdetails oder Wasserzeichen. ### 8.3. Bildaufbau, Perspektive und Licht * Halbweite Aufnahme in einem hellen, seriösen deutschen Notariat oder Besprechungsraum. * Maklerperson, Kundenpaar und Notarin oder Notar sitzen gemeinsam an einem großen Tisch. * Natürliches Tageslicht mit weicher, nicht sichtbarer Innenraumaufhellung. ### 8.4. Schärfe, Tiefenwirkung und Integration * Fujifilm X-T5 mit 35-mm-Objektiv, ca. 53 mm KB-äquivalent, f/5.6, 1/125 s, ISO 500. * Optischer Fokus auf Vertragsunterzeichnung und Gesichter der Beteiligten. * Hintergrund leicht unscharf, Tisch und Personen bleiben glaubwürdig miteinander verbunden. ### 8.5. Inszenierung * Freundliche, professionelle und rechtlich verbindliche Abschlusssituation. * Alle Beteiligten wirken aufmerksam, ruhig und natürlich; kein Blick in die Kamera.`
  - `C1 Beratungsgespräch mit Senioren (zuhause)` → Promptwert: `* Die Maklerperson berät ein älteres Paar an einem Tisch in dessen Zuhause. * Die Maklerperson ist nur von hinten beziehungsweise über die Schulter im unscharfen Vordergrund sichtbar; das Seniorenpaar bildet den klaren Fokus der Szene. * Auf dem Tisch liegen einige neutrale Vertragsunterlagen oder Listen sowie optional ein Stift, ein Block und Tassen oder Gläser. * Keine Exposés, keine Prospekte mit Bildern, keine lesbaren Texte, keine Logos und keine Wasserzeichen. * Der Raum ist hell, ordentlich und wohnlich eingerichtet, mit neutraler Einrichtung und dezenten Wandbildern im Hintergrund. * Die Szene vermittelt eine ruhige, vertrauensvolle Beratungssituation ohne Verkaufsdruck und ohne dominanten Neubaucharakter. ### 8.3. Bildaufbau, Perspektive und Licht * Over-the-shoulder-Perspektive aus Sicht der Maklerperson, als mittlere Nahaufnahme mit klarem Blick auf das ältere Paar. * Die beiden Kundinnen oder Kunden sitzen sich leicht zur Maklerperson zugewandt gegenüber und wirken gut als gemeinsame Gesprächseinheit erkennbar. * Natürliches Tageslicht sorgt für eine helle, angenehme und glaubwürdige Wohnatmosphäre. ### 8.4. Schärfe, Tiefenwirkung und Integration * Fujifilm X-T5 mit 35-mm-Objektiv, ca. 53 mm KB-äquivalent, f/4, 1/125 s, ISO 400. * Der optische Fokus liegt auf den Gesichtern und Reaktionen des Seniorenpaares; die Maklerperson bleibt im Vordergrund bewusst weich unscharf. * Leichte Tiefenunschärfe und natürliche Raumtiefe sorgen für eine realistische, fotografische Integration ohne künstliche Freistellung. ### 8.5. Inszenierung * Das ältere Paar wirkt freundlich, interessiert und vertrauensvoll, mit natürlichem Lächeln und aufmerksamem Blick zur beratenden Maklerperson. * Die Atmosphäre ist zugewandt, seriös und ruhig, nicht gestellt oder stockfotoartig. * Die gesamte Szene soll wie eine echte, sensible Beratung im privaten Wohnumfeld wirken.`
  - `C2 Beratungsgespräch mit Paar (zuhause)` → Promptwert: `* Die Maklerperson berät ein junges Paar in dessen Zuhause. * Die Maklerperson ist im Vordergrund von hinten zu sehen und bleibt leicht unscharf; das Paar bildet das Hauptmotiv der Szene. * Das Paar sitzt nah nebeneinander, lehnt sich leicht nach vorn und schaut aufmerksam zur Maklerperson. * Der Wohnraum ist hell, freundlich, aufgeräumt und wohnlich, mit Fenstern und einer neutralen, gepflegten Einrichtung. * Sichtbare Materialien bleiben dezent, seriös, markenfrei und ohne lesbare Texte, Logos oder Wasserzeichen. * Die gewünschte Bildwirkung ist vertrauensvoll, positiv und alltagsnah und zeigt eine glaubwürdige Beratung im privaten Umfeld. ### 8.3. Bildaufbau, Perspektive und Licht * Kamera in leicht erhöhter Augenhöhe mit Blick über die Schulter der Maklerperson auf das Paar. * Halbnahe bis mittlere Aufnahme mit ausgewogenem Bildaufbau, sodass Paar, Sitzsituation und Wohnumfeld klar erkennbar bleiben. * Natürliches Tageslicht erzeugt eine helle, freundliche und wohnliche Atmosphäre ohne harte Schatten. ### 8.4. Schärfe, Tiefenwirkung und Integration * Fujifilm X-T5 mit 35-mm-Objektiv, ca. 53 mm KB-äquivalent, f/4, 1/125 s, ISO 400. * Der optische Fokus liegt auf den Gesichtern des Paares und auf deren Reaktion im Gespräch; die Maklerperson im Vordergrund bleibt weich unscharf. * Leichte Tiefenunschärfe, natürliche Proportionen und eine glaubwürdige Einbindung in den Raum ohne künstliche Freistellung. ### 8.5. Inszenierung * Das Paar wirkt offen, aufmerksam und freundlich und vermittelt Interesse, Vertrauen und eine positive Gesprächsdynamik. * Die Szene soll beobachtet und authentisch wirken, nicht wie eine überinszenierte Werbesituation. * Körpersprache, Blickrichtung und Sitzhaltung bleiben natürlich und entspannt.`
  - `C3 360-Grad-Fotografie` → Promptwert: `* Eine lächelnde Maklerperson steht in einem hellen, modernen Wohnzimmer. * Die Maklerperson befindet sich rechts im Bild, blickt direkt in die Kamera und spricht den Betrachter oder die Betrachterin offen an. * Beide Hände sind leicht angehoben und geöffnet, als würde die Person gerade etwas erklären. * Links im Vordergrund steht eine schwarze 360-Grad-Kamera auf einem Stativ, klar sichtbar, aber nicht bilddominant. * Der Raum ist schlicht, stilvoll und hochwertig eingerichtet, mit Holzfußboden, minimalistischer Möblierung und großen bodentiefen Fenstern mit hellen Vorhängen. * Keine weiteren Personen, keine Logos, keine Wasserzeichen und keine unnötig auffälligen Markenhinweise. ### 8.3. Bildaufbau, Perspektive und Licht * Leichte Weitwinkelperspektive mit ausgewogener Komposition und klarer Tiefenstaffelung zwischen Kamera im Vordergrund, Maklerperson und Wohnraum. * Die Maklerperson bleibt das Hauptmotiv, während die 360-Grad-Kamera als ergänzendes technisches Element deutlich erkennbar ist. * Warmes natürliches Tageslicht fällt durch die großen Fenster in den Raum und erzeugt eine helle, freundliche Wohnatmosphäre mit sanften Schatten. ### 8.4. Schärfe, Tiefenwirkung und Integration * Fujifilm X-T5 mit 23-mm-Objektiv, ca. 35 mm KB-äquivalent, f/5.6, 1/125 s, ISO 400. * Der optische Fokus liegt auf der Maklerperson; die Kamera im Vordergrund und der Wohnraum bleiben ausreichend scharf und glaubwürdig integriert. * Die Szene zeigt eine natürliche Tiefenwirkung ohne extreme Verzeichnung oder künstliche Freistellung. ### 8.5. Inszenierung * Die Maklerperson wirkt freundlich, nahbar und professionell und vermittelt eine offene Erklärungssituation. * Die Szene soll modern, hochwertig und authentisch erscheinen, nicht wie ein Technik-Werbespot. * Der Gesamteindruck verbindet Immobilienkompetenz, Wohnlichkeit und digitale Arbeitsweise auf glaubwürdige Weise.`
  - `D1 Maklerperson im leeren Bestandsobjekt` → Promptwert: `* Die Maklerperson steht alleine in einem leeren Immobilienobjekt. * Es handelt sich um einen gepflegten Bestandsbau ohne Altbaucharakter und ohne dominante Neubauästhetik. * Die Räume sind hell, unmöbliert und neutral gestaltet, mit weißen Wänden, schlichtem Boden und großen Fenstern. * Die Maklerperson hält ein Tablet in einer Hand, schreibt mit einem digitalen Stift darauf und schaut sich aufmerksam im Raum um. * Die Körperhaltung wirkt ruhig, professionell und konzentriert; der Gesichtsausdruck ist prüfend und sachlich. * Keine Möbel, keine weiteren Personen, keine Logos, keine lesbaren Texte und keine Wasserzeichen. ### 8.3. Bildaufbau, Perspektive und Licht * Natürliche, leicht ungewöhnliche Perspektive mit klarer Raumwirkung und glaubwürdigem Immobilienfotografie-Charakter. * Die Maklerperson bleibt als zentrales Motiv klar erkennbar, während zugleich ausreichend Umgebung sichtbar ist, um das leere Objekt eindeutig lesbar zu machen. * Natürliches Tageslicht fällt durch die großen Fenster ein und erzeugt eine helle, ruhige und professionelle Atmosphäre. ### 8.4. Schärfe, Tiefenwirkung und Integration * Fujifilm X-T5 mit 23-mm-Objektiv, ca. 35 mm KB-äquivalent, f/5.6, 1/125 s, ISO 500. * Der optische Fokus liegt auf der Maklerperson, dem Tablet und der Arbeitssituation; der Raum bleibt ausreichend scharf und klar erfassbar. * Dezente Tiefenwirkung und natürliche Perspektive sorgen für eine realistische Einbindung ohne künstliche Freistellung oder extreme Verzeichnung. ### 8.5. Inszenierung * Die Szene wirkt wie eine echte Prüfung oder Bestandsaufnahme vor Ort und nicht wie eine gestellte Werbeaufnahme. * Die Maklerperson vermittelt Kompetenz, Aufmerksamkeit und Professionalität. * Der Gesamteindruck ist sachlich, hochwertig und authentisch und verbindet Immobilienbezug mit glaubwürdiger Arbeitssituation.`
  - `D2 Wohnungsbesichtigung` → Promptwert: `* Die Maklerperson führt ein Paar durch eine leere, moderne Wohnung. * Die Maklerperson erklärt Details zur Raumaufteilung, Ausstattung oder zu möglichen Nutzungsmöglichkeiten. * Eine Hand oder Geste weist auf einen Bereich im Raum, zum Beispiel auf Decke, Wand, Fenster oder Lichtinstallation. * Das Paar steht nah beieinander und betrachtet aufmerksam die Wohnung sowie die Hinweise der Maklerperson. * Die Wohnung ist hell, neutral und unmöbliert, mit großen Fenstern und einem weiten Ausblick nach draußen. * Die Szene vermittelt eine professionelle, freundliche und entscheidungsorientierte Besichtigungssituation. ### 8.3. Bildaufbau, Perspektive und Licht * Weite Totale mit ausgewogener Raumdarstellung, sodass Personen, Interaktion und Wohnraum gut erkennbar bleiben. * Die Maklerperson und das Paar sind klar als Hauptmotiv lesbar, gleichzeitig bleibt genug Umgebung sichtbar, um die Wohnungsbesichtigung eindeutig zu zeigen. * Großzügiges Tageslicht durch große Fenster sorgt für eine helle, offene und realistische Immobilienatmosphäre. ### 8.4. Schärfe, Tiefenwirkung und Integration * Fujifilm X-T5 mit 23-mm-Objektiv, ca. 35 mm KB-äquivalent, f/5.6, 1/125 s, ISO 500. * Der optische Fokus liegt auf den Personen und ihrer Interaktion; Raumdetails und Architektur bleiben ausreichend scharf und natürlich eingebunden. * Die Aufnahme besitzt eine klare, natürliche Raumtiefe ohne extreme Weitwinkelverzerrung oder künstliche Freistellung. ### 8.5. Inszenierung * Die Szene soll wie eine glaubwürdige Immobilienbesichtigung wirken, nicht wie ein generisches Stockfoto. * Ausdruck, Gesten und Körperhaltung aller Beteiligten wirken aufmerksam, freundlich und natürlich. * Der Gesamteindruck verbindet Wohnraum, Beratung und Entscheidungsfindung auf authentische Weise.`
  - `D3 Wohnungsbesichtigung mit Familie` → Promptwert: `* Die Maklerperson erklärt der Familie etwas und hält ein Tablet oder Smartphone. * Eltern stehen eng zusammen; ein Mädchen links und ein jüngerer Junge mittig vor den Erwachsenen. * Der Raum besitzt weiße Wände, hohe Fenster, warme Holzdielen, klassische Wandpaneele und eine hohe Decke. * Eine große Holzeingangstür ist links im Hintergrund sichtbar. * Keine weiteren Personen, Logos, Texte oder Wasserzeichen. ### 8.3. Bildaufbau, Perspektive und Licht * Weite, natürliche Aufnahme eines hellen, leeren Wohnraums. Familie und Maklerperson sind vollständig erkennbar. * Starkes, weiches Tageslicht fällt von rechts ein. * Die Maklerperson steht rechts; die Familie bildet eine zusammengehörige Gruppe links und mittig. ### 8.4. Schärfe, Tiefenwirkung und Integration * Fujifilm X-T5 mit 23-mm-Objektiv, ca. 35 mm KB-äquivalent, f/5.6, 1/125 s, ISO 500. * Optischer Fokus auf Personen und Interaktion; Raumdetails bleiben ausreichend scharf. * Natürliche Raumtiefe ohne extreme Weitwinkelverzerrung oder künstliche Freistellung. ### 8.5. Inszenierung * Glaubwürdige Immobilienbesichtigung mit freundlicher, vertrauensvoller Atmosphäre. * Eltern und Kinder wirken interessiert und entspannt. Kein Blick in die Kamera.`
  - `E1 Freigestelltes Marketing-Porträt` → Promptwert: `* Die Maklerperson steht komplett freigestellt auf weißem oder transparentem Hintergrund. * Die Person ist professionell gekleidet und hält optional eine neutrale Mappe oder ein Exposé in der Hand. * Mappe oder Exposé bleiben markenfrei, ohne Logos und ohne lesbare Inhalte. * Die Maklerperson blickt direkt in die Kamera, lächelt freundlich und souverän und zeigt eine offene, professionelle Körperhaltung. * Das Motiv soll als sauberes, vielseitig einsetzbares Cutout für Website, Flyer oder Social Media nutzbar sein. * Keine weiteren Personen, keine zusätzlichen Objekte, keine Wasserzeichen und keine störenden Hintergrunddetails. ### 8.3. Bildaufbau, Perspektive und Licht * Frontaler, klarer Portraitaufbau mit vollständiger Freistellung der Person und sauberem, ruhigem Bildrand. * Die Pose bleibt aufrecht, natürlich und gut ausbalanciert, sodass ein hochwertiges Marketing-Porträt entsteht. * Weiches, professionelles Studiolicht sorgt für eine gleichmäßige Ausleuchtung ohne harte Schatten und mit natürlicher Hautwirkung. ### 8.4. Schärfe, Tiefenwirkung und Integration * Fujifilm X-T5 mit 56-mm-Objektiv, ca. 85 mm KB-äquivalent, f/5.6, 1/125 s, ISO 200. * Der optische Fokus liegt präzise auf Gesicht und Augen; Kleidung, Hände und optionales Exposé bleiben klar und sauber dargestellt. * Die Darstellung ist scharf, neutral und technisch sauber, ohne unnötige Tiefenunschärfe oder inszenierte Raumwirkung. ### 8.5. Inszenierung * Die Maklerperson wirkt vertrauenswürdig, professionell und sympathisch. * Die Szene soll klar, modern und hochwertig erscheinen und nicht wie ein billiges Freisteller-Stockfoto. * Der Gesamteindruck ist repräsentativ, vielseitig verwendbar und professionell reduziert.`
  - `E2 Zollstock-Durchblick 2 (neutraler Hintergrund)` → Promptwert: `* Das Gesicht erscheint mittig innerhalb der Hauskontur. * Viel freier Raum unterstützt die grafische Bildidee. * Motiv steht für Eigenheim, Hauskauf oder Immobilienberatung. * Keine weiteren Personen, Logos, Texte oder Wasserzeichen. ### 8.3. Bildaufbau, Perspektive und Licht * Zentrale Frontansicht mit direktem Blick in die Kamera. * Ein nach vorn gehaltener Holz-Zollstock bildet deutlich eine Hausform um das Gesicht. * Der Zollstock liegt näher an der Kamera und erzeugt eine dezente Tiefenwirkung. ### 8.4. Schärfe, Tiefenwirkung und Integration * Fujifilm X-T5 mit 35-mm-Objektiv, ca. 53 mm KB-äquivalent, f/4, 1/125 s, ISO 200. * Optischer Fokus auf Gesicht und Augen; der vordere Zollstock darf leicht unscharf sein, seine Hausform bleibt lesbar. * Heller Hohlkehlen-Hintergrund, gleichmäßiges Studiolicht und sanfte Schatten. ### 8.5. Inszenierung * Freundlicher, positiver Ausdruck mit klarer, zentraler Komposition. * Hände und Zollstock bilden die Hausform plausibel, ohne verdrehte Finger oder gebrochene Segmente.`
  - `E3 Erklärvideo-Standbild` → Promptwert: `* Die Maklerperson steht oder sitzt rechts der Bildmitte in einer professionellen Beratungssituation. * Die Person blickt direkt in die Kamera und zeigt einen seriösen, beratenden und ansprechenden Gesichtsausdruck. * Die Hände befinden sich in einladenden, erklärenden Gesten vor dem Körper oder leicht nach links gewandt. * Links im Bild bleibt ein großer, freier Copyspace für Text oder Gestaltungselemente. * Der Hintergrund ist hellgrau, als Verlauf, Wand oder neutrale Fläche mit Beton- oder Steincharakter denkbar. * Oben rechts oder rechts hinter der Maklerperson darf ein unscharfes Immobilienlogo erscheinen; ein konkretes Firmenlogo jedoch nur dann, wenn eine passende Logodatei hochgeladen wurde. Ohne Logodatei bleibt die Fläche neutral. ### 8.3. Bildaufbau, Perspektive und Licht * Videoartige, ruhige Komposition im Querformat mit klarer Gewichtung: Person rechts, Freifläche links. * Die Maklerperson ist das scharf fokussierte Hauptmotiv und wirkt wie in einem professionellen Erklärvideo-Standbild. * Weiches, professionelles Studiolicht sorgt für eine gleichmäßige Ausleuchtung und einen hochwertigen, ruhigen Look. ### 8.4. Schärfe, Tiefenwirkung und Integration * Fujifilm X-T5 mit 35-mm-Objektiv, ca. 53 mm KB-äquivalent, f/4 bis f/5.6, 1/125 s, ISO 200. * Der optische Fokus liegt auf Gesicht, Augen und Händen; Hintergrund und mögliches Logo bleiben dezent weich und untergeordnet. * Leichte Tiefenwirkung trennt die Person glaubwürdig vom Hintergrund, ohne künstliche Freistellung oder übertriebenen Bokeh-Effekt. ### 8.5. Inszenierung * Die Szene vermittelt Kompetenz, Nahbarkeit und eine seriöse Erklärsituation. * Ausdruck, Haltung und Gestik wirken ruhig, klar und glaubwürdig, nicht theatralisch oder stockfotoartig. * Der Gesamteindruck eignet sich für Webseiten, Erklärvideos oder Social-Media-Standbilder mit professioneller Anmutung.`

### Bild beschriften

- API-Schlüssel in `values`: `2887`
- Typ: Einzelauswahl (`radio`)
- Pflichtfeld: ja
- Zulässige Werte (genau die Bezeichnung senden):
  - `an` → Promptwert: `## 11. Bild beschriften Schreibe mit weißer Schrift rechts unten ins Bild: den Titel von 6.2. , Titel von 5.1. , daneben, falls vorhanden, den Titel von 7.3. ohne die Worte "Regionale Zuordnung"`
  - `aus` → Promptwert: `.`

## Datei- und Bildeingaben

- **Referenzfoto 1** (`field_alias=407`): Pflicht, maximal 500 MB, akzeptiert `.jpg,.jpeg,.png,.webp,.gif`. Gruppe: Setcard oder Fotos hochladen.
- **Referenzfoto 2** (`field_alias=408`): optional, maximal 500 MB, akzeptiert `.jpg,.jpeg,.png,.webp,.gif`. Gruppe: Setcard oder Fotos hochladen.
- **Referenzfoto 3** (`field_alias=409`): optional, maximal 500 MB, akzeptiert `.jpg,.jpeg,.png,.webp,.gif`. Gruppe: Setcard oder Fotos hochladen.
- **Referenzfoto 4** (`field_alias=410`): optional, maximal 500 MB, akzeptiert `.jpg,.jpeg,.png,.webp,.gif`. Gruppe: Setcard oder Fotos hochladen.

## Abhängigkeiten zwischen Eingaben

- Wenn **Geschlecht** den Wert `Frau` hat, sind bei **Kleidung** nur `Business Formal - Frau, Business Professional - Frau, Business Casual - Frau, Smart Casual - Frau, Corporate / Branded - Frau, Creative Professional - Frau, Tech Casual - Frau, Privat - Frau` erlaubt.

## 3. Was kommt als Ergebnis?

Ein gestarteter Lauf liefert die Run-ID unter `data.run.id`, nicht unter `run_id`. Bei einem Multitest oder Mehrfachstart stehen alle IDs unter `data.runs[].id`. Frage jeden Lauf danach bis zu einem Endstatus ab. Je nach Projekt und Anbieter enthält das Ergebnis `result_text`, `result_images` oder beides. Bei einem Fehler steht die Erklärung in `error_text`.

Für verkettete Abläufe: Übernimm `result_text` als Wert eines passenden Text- oder Textbereich-Feldes im nächsten Projekt. Bilder müssen über die weiter unten in dieser Datei beschriebenen Datei-/Ressourcenendpunkte weitergegeben werden. Erfinde keine Feldzuordnung; nutze die Projekt-LLM des Zielprojekts.

## 4. Empfohlener API-Ablauf

1. Lade `GET https://bki.flex.immonia.com/api/v1/projects/18/workbench?draft_key=<UUIDv4>` und gleiche den aktiven Stand mit dieser Datei ab.
2. Lade notwendige Ressourcen mit demselben `draft_key` hoch oder wähle sie aus.
3. Prüfe die Eingaben mit `POST https://bki.flex.immonia.com/api/v1/projects/18/prompt/resolve`. Fahre nur fort, wenn `data.prompt.valid` wahr ist.
4. Starte mit `POST https://bki.flex.immonia.com/api/v1/projects/18/runs` und einem neuen `Idempotency-Key`.
5. Lies beim Einzelstart `data.run.id`; bei mehreren Läufen lies alle Werte aus `data.runs[].id`.
6. Frage für jede ID `GET https://bki.flex.immonia.com/api/v1/runs/<run_id>` ab und lies `data.status`, bis der Lauf `succeeded` oder `failed` ist.

Beispielkörper für Promptprüfung und Teststart:

```json
{
  "provider": "REPLACE_WITH_PROVIDER_FROM_WORKBENCH",
  "values": {
    "2879": "<Größe in cm angeben>",
    "2880": "Mann",
    "2881": "Business Formal - Mann",
    "2882": "Corporate",
    "2883": "Außen",
    "2884": "1. Küstennahe Kleinstadt",
    "2885": "Querformat 16:9",
    "2886": "A1 Makler lehnt am Vorgarten",
    "2887": "an"
  },
  "section_texts": {},
  "draft_key": "<frische UUIDv4>"
}
```

`REPLACE_WITH_PROVIDER_FROM_WORKBENCH` ist ein verpflichtender Platzhalter. Ersetze ihn durch die ID eines Anbieters aus `data.providers` der aktuellen Workbench-Antwort. Erfinde keinen Anbieter und behandle keinen Anbieter als globalen Standard.
Die Startantwort ist in das allgemeine BKI-Antwortformat eingebettet: `data.run.id` ist die primäre Lauf-ID. Es gibt kein `run_id` auf der obersten Ebene und kein `data.run_id`. Wenn trotz HTTP 202 keine ID vorhanden ist, bewahre `request_id` und den verwendeten Idempotency-Key auf und starte nicht blind erneut.

## Maschinenlesbarer Projektvertrag

```json
{
  "schema": "bki.project-llm.v1",
  "project": {
    "id": 18,
    "name": "KI-Foto-Studio Version Tom",
    "description": "Erstellt professionelle KI-Fotoshootings mit vielseitigen Innen- und Außenaufnahmen.",
    "active_master_version": "7.9.3"
  },
  "input_fields": [
    {
      "id": 2879,
      "api_alias": null,
      "label": "Größe in cm angeben",
      "type": "text",
      "required": true,
      "accepted_values": null
    },
    {
      "id": 2880,
      "api_alias": null,
      "label": "Geschlecht",
      "type": "radio",
      "required": true,
      "accepted_values": [
        "Mann",
        "Frau"
      ]
    },
    {
      "id": 2881,
      "api_alias": null,
      "label": "Kleidung",
      "type": "select",
      "required": true,
      "accepted_values": [
        "Business Formal - Mann",
        "Business Professional - Mann",
        "Business Casual - Mann",
        "Smart Casual - Mann",
        "Corporate / Branded - Mann",
        "Creative Professional - Mann",
        "Tech Casual - Mann",
        "Privat - Mann",
        "wie Referenzfoto ohne Bildauswahl",
        "Business Formal - Frau",
        "Business Professional - Frau",
        "Business Casual - Frau",
        "Smart Casual - Frau",
        "Corporate / Branded - Frau",
        "Creative Professional - Frau",
        "Tech Casual - Frau",
        "Privat - Frau"
      ]
    },
    {
      "id": 2882,
      "api_alias": null,
      "label": "Bildstil",
      "type": "select",
      "required": true,
      "accepted_values": [
        "Corporate",
        "Lifestyle-/Reportage",
        "Editorial",
        "Environmental",
        "Highkey",
        "Schwarz-Weiß",
        "Corporate-Tech"
      ]
    },
    {
      "id": 2883,
      "api_alias": null,
      "label": "Location-Kategorie",
      "type": "select",
      "required": true,
      "accepted_values": [
        "Außen",
        "Büro",
        "Zuhause beim Kunden",
        "Im Objekt",
        "Erweitert/Sonstige"
      ]
    },
    {
      "id": 2884,
      "api_alias": null,
      "label": "Region",
      "type": "select",
      "required": false,
      "accepted_values": [
        "1. Küstennahe Kleinstadt",
        "2. Backstein-Wohnstraße",
        "3. Flachland – ländlicher Ortsrand",
        "4. Einkaufsstraße in historischer Altstadt",
        "5. Großstadt – Altbaustraße",
        "6. Mittelgebirge – Kurort / Kleinstadt",
        "7. Kleinstadt – gewachsene Wohnstraße",
        "8. Flachland – offene Wohnsiedlung",
        "9. Plattenbau modernisiert",
        "10. Sanierte Altbauten",
        "11. Süddeutschland – alpennahe Wohnlage",
        "12. Süddeutschland – gepflegte Vorstadt",
        "13. Dorf – klassischer Ortskern",
        "14. Mittelgebirge – Hangstraße",
        "15. Großstadt – Neubauviertel",
        "16. Büroimmobilien",
        "17. Bergisches Land – Fachwerk und Hanglage",
        "18. Bergisches Land – modernes Einfamilienhaus",
        "19. Klassische Wohnsiedlung Reihenhäuser und Vorgärten",
        "20. Wohnstraße mit 50er-Jahre-Mehrfamilienhäusern",
        "21. Urbaner Vorort",
        "22. Metropole – urbanes Büro- und Neubauviertel",
        "23. Gewerbegebiet"
      ]
    },
    {
      "id": 2885,
      "api_alias": null,
      "label": "Bildformat",
      "type": "select",
      "required": true,
      "accepted_values": [
        "Querformat 16:9",
        "Hochformat 9:16",
        "Quadrat 1:1"
      ]
    },
    {
      "id": 2886,
      "api_alias": null,
      "label": "Bildszene",
      "type": "select",
      "required": true,
      "accepted_values": [
        "A1 Makler lehnt am Vorgarten",
        "A2 Gespräch auf dem Wochenmarkt",
        "A3 Drohne im Vordergrund",
        "A4 Drohne im Hintergrund",
        "A5 Makler steht mit Paar vor Objekt",
        "B1 Schlüsselübergabe",
        "B2 Telefonat mit Kunden im Büro",
        "B3 Beratungsgespräch mit Senioren im Büro",
        "B4 Konzentriertes Arbeiten",
        "B5 Beratungsgespräch am Schreibtisch",
        "B6 Daumen hoch im Büro",
        "B7 Maklerperson erklärt ernst ins Off",
        "B8 Maklerperson hinter dem Notebook mit Daumen hoch",
        "B9 Freundliche Erklärung rechts ins Off",
        "B10 Erklärung in einer Seminarsituation",
        "B11 Portrait im Büroflur mit Logo",
        "B11.V2 Portrait im Büroflur mit Logo an Stirnwand",
        "B12 Ganzkörperportrait im Büroflur mit Wandlogo",
        "B13 Schulterzucken am Schreibtisch",
        "B14 Offene Ansprache mit Freifläche links",
        "B15 Zollstock-Durchblick 1 (Büro)",
        "B16 Beratungsgespräch over the shoulder",
        "B17 Daumen hoch vor unscharfem Bürohintergrund",
        "B18 Kollegengespräch im Besprechungsraum",
        "B19 Beratungsgespräch mit jungem Paar",
        "B20 Geschäftlicher Handschlag",
        "B21 Erfolgreicher Abschluss im Meeting",
        "B22 Vertragsunterzeichnung beim Notar",
        "C1 Beratungsgespräch mit Senioren (zuhause)",
        "C2 Beratungsgespräch mit Paar (zuhause)",
        "C3 360-Grad-Fotografie",
        "D1 Maklerperson im leeren Bestandsobjekt",
        "D2 Wohnungsbesichtigung",
        "D3 Wohnungsbesichtigung mit Familie",
        "E1 Freigestelltes Marketing-Porträt",
        "E2 Zollstock-Durchblick 2 (neutraler Hintergrund)",
        "E3 Erklärvideo-Standbild"
      ]
    },
    {
      "id": 2887,
      "api_alias": null,
      "label": "Bild beschriften",
      "type": "radio",
      "required": true,
      "accepted_values": [
        "an",
        "aus"
      ]
    }
  ],
  "resource_fields": [
    {
      "id": 407,
      "api_alias": null,
      "label": "Referenzfoto 1",
      "required": true,
      "accept": ".jpg,.jpeg,.png,.webp,.gif",
      "max_mb": 500
    },
    {
      "id": 408,
      "api_alias": null,
      "label": "Referenzfoto 2",
      "required": false,
      "accept": ".jpg,.jpeg,.png,.webp,.gif",
      "max_mb": 500
    },
    {
      "id": 409,
      "api_alias": null,
      "label": "Referenzfoto 3",
      "required": false,
      "accept": ".jpg,.jpeg,.png,.webp,.gif",
      "max_mb": 500
    },
    {
      "id": 410,
      "api_alias": null,
      "label": "Referenzfoto 4",
      "required": false,
      "accept": ".jpg,.jpeg,.png,.webp,.gif",
      "max_mb": 500
    }
  ],
  "conditions": [
    {
      "trigger_field_id": 2880,
      "trigger_value": "Frau",
      "target_field_id": 2881,
      "behavior": "disable",
      "allowed_values": [
        "Business Formal - Frau",
        "Business Professional - Frau",
        "Business Casual - Frau",
        "Smart Casual - Frau",
        "Corporate / Branded - Frau",
        "Creative Professional - Frau",
        "Tech Casual - Frau",
        "Privat - Frau"
      ]
    }
  ],
  "output": {
    "start_endpoint": "/projects/18/runs",
    "start_response_run_id": "data.run.id",
    "start_response_all_run_ids": "data.runs[].id",
    "run_endpoint": "/runs/{run_id}",
    "fields": [
      "status",
      "result_text",
      "result_images",
      "error_text"
    ],
    "chain_hint": "result_text kann als Textfeldwert eines weiteren BKI-Projekts verwendet werden."
  }
}
```

## Vollständige persönliche BKI-API-Dokumentation

Die folgenden Regeln, Routen, Beispiele und Berechtigungen sind Bestandteil dieser Projektdatei. Sie gelten gemeinsam mit dem oben beschriebenen Projektvertrag.

# BKI API – persönliche LLM-Anleitung

Diese Datei erklärt einem LLM, wie es die BKI API im Namen von **Christian Fiacco** verwendet.

## Verbindung

- API-Basis: `https://bki.flex.immonia.com/api/v1`
- OpenAPI: `https://bki.flex.immonia.com/api/v1/openapi.json`
- Benutzer: `chris`
- Rolle: `admin`
- Generiert: `2026-09-30T08:04:15Z`
- API-Limit: `3650` Anfragen je Projekt innerhalb von 24 Stunden

## Authentifizierung

Verwende bei jeder geschützten Anfrage exakt diesen Header:

```http
Authorization: Bearer bki_KJXrI-CD4VOkXN2777tyyXSjtWeQTpfAUbhXOaW2ahs
Accept: application/json
```

Setze `Content-Type: application/json` nur bei JSON-Bodies. Bei Datei-Uploads mit
`multipart/form-data` darf der Client den Header einschließlich Boundary selbst erzeugen
(`curl -F`); setze dort keinen JSON-Content-Type.

Der Schlüssel ist geheim. Gib ihn niemals in Antworten, Logs oder Fehlermeldungen aus. Verwende ihn nur gegenüber `https://bki.flex.immonia.com/api/v1`. Wenn eine Anfrage mit `401 AUTH_REQUIRED` antwortet, wurde der Schlüssel möglicherweise rotiert oder gesperrt; lade dann eine neue `llm.md` aus BKI herunter.

## Verfügbare Scopes

- `profile:read`
- `profile:write`
- `projects:read`
- `projects:write`
- `workbench:read`
- `workbench:write`
- `runs:read`
- `runs:start`
- `runs:cancel`
- `runs:retry`
- `runs:delete`
- `resources:read`
- `resources:write`
- `files:read`
- `files:write`
- `tags:read`
- `tags:write`
- `assignments:write`
- `master_prompts:read`
- `master_prompts:write`
- `master_prompts:activate`
- `options:read`
- `options:write`
- `dynamic_fields:read`
- `dynamic_fields:write`
- `results:read`
- `results:import`
- `users:read`
- `users:write`
- `api_keys:rotate`
- `settings:read`
- `settings:write`
- `support:write`
- `browsercloud:manage`
- `system:read`
- `audit:read`

## Arbeitsablauf

1. Rufe `GET /me` auf und prüfe Identität sowie Scopes.
2. Rufe `GET /projects?limit=50&offset=0` auf. Erfinde niemals Projekt-IDs.
3. Erzeuge eine frische UUIDv4 und lade `GET /projects/{project_id}/workbench?draft_key={uuid_v4}`. Nutze ausschließlich die gelieferten Binding-IDs oder `api_alias`-Namen, Optionswerte, Bedingungen, Ressourcenfelder und Provider.
4. Prüfe Eingaben mit `POST /projects/{project_id}/prompt/resolve`.
   - Sende `Content-Type: application/json`. Body, `values` und `section_texts` müssen JSON-Objekte sein: leer `{}`, niemals `[]` oder `null`. Arrays als einzelne Feldwerte innerhalb von `values` sind für Mehrfachauswahl erlaubt. Fehlende `values`/`section_texts` verwenden den Standard `{}`.
   - HTTP `422 ACTION_REJECTED`: Lies `error.errors`. Jeder Eintrag nennt `parameter` (`body`, `values`, `section_texts`), `code`, `expected_type`, `actual_type` und `message`. Beispiel: `parameter=values`, `code=INVALID_TYPE`, `expected_type=object`, `actual_type=array`: korrigiere `values` von `[]` zu `{}` beziehungsweise einem Objekt mit Binding-IDs oder gelieferten API-Aliasnamen.
   - `INVALID_JSON` bedeutet ungültiges JSON oder falschen Content-Type. Mehrere falsche Parameter werden gemeinsam gemeldet. Gib niemals API-Key oder vollständige Eingabeinhalte zum Debuggen aus.
   - HTTP `200` heißt nicht automatisch fachlich gültig: Prüfe `data.prompt.valid`. Feldfehler stehen unter `data.prompt.errors` mit `binding_id`, `label`, `code` und `message`. Starte keinen Test bei `valid=false`.
5. Lade benötigte Dateien über `POST /resources/upload` hoch oder wähle sie mit `POST /resources/select` aus.
6. Starte Tests mit `POST /projects/{project_id}/runs` und einem neuen `Idempotency-Key`.
7. Lies die Lauf-ID aus `data.run.id` der `202`-Antwort. Die Startantwort besitzt bewusst
   kein Feld `run_id` auf der obersten Ebene. Frage danach `GET /runs/{run_id}` ab und
   lies den Zustand aus `data.status`, bis er `succeeded` oder `failed` ist. Bei einem
   Multitest oder Mehrfachstart stehen alle Lauf-IDs zusätzlich in `data.runs[].id`; verfolge
   dann jeden Eintrag einzeln. Aktive Läufe können über `POST /runs/{run_id}/cancel`
   beendet werden.
8. Wenn OpenAPI für eine Operation `Idempotency-Key` als Pflichtparameter markiert oder
   `/capabilities` `idempotency_required: true` meldet, wiederhole sie nur mit demselben
   Schlüssel und unverändertem Body. Derselbe Schlüssel mit geändertem Body ergibt HTTP 409.
   Bei `IDEMPOTENCY_IN_PROGRESS` beachte `Retry-After`, sofern vorhanden. Teststarts speichern
   Auftrag und wiederholbare Antwort gemeinsam. Offene Reservierungen werden nicht automatisch
   freigegeben: Nach fünf Minuten kann der Ausgang unklar sein; dann fehlen `Retry-After` und
   eine Freigabe zur Wiederholung. Prüfe vorhandene Aufträge oder kontaktiere den Support mit
   der `request_id`; verwende keinen neuen Schlüssel zum blinden Wiederholen. Andere
   Operationen erhalten keinen unnötigen Schlüssel.

## Ergebnisbilder lesen und herunterladen

Ein erfolgreicher `GET /runs/{run_id}` liefert Ergebnisbilder in `data.result_images` als
stabile, authentifizierte URLs. Die URL endet mit dem konfigurierten Anzeigenamen und wird
mit demselben Bearer-Token und dem Scope `runs:read` geladen. BKI liefert echte Bilddateien statt Base64 im JSON.

```bash
curl -k --fail-with-body   -H 'Authorization: Bearer bki_KJXrI-CD4VOkXN2777tyyXSjtWeQTpfAUbhXOaW2ahs'   -H 'Accept: image/*'   -o ergebnisbild.webp   'https://bki.flex.immonia.com/api/v1/result-images/REPLACE_WITH_IMAGE_ID/content/REPLACE_WITH_DISPLAY_NAME'
```

Verwende ausschließlich die vom Lauf gelieferte URL. Erfinde weder Bild-ID noch Dateiname:
Das globale Dateinamensschema kann pro Projekt überschrieben werden. Mehrere Bilder eines
Laufs erhalten auch ohne `image_index` im Schema eindeutige Namen.

## Projektfelder abfragen und verstehen

Wenn der Nutzer nach den **Feldern**, **Eingaben**, **Formularfeldern**, **Pflichtfeldern**,
**Auswahlmöglichkeiten** oder danach fragt, was er in einem Projekt ausfüllen kann, rufe
immer `GET /projects/{project_id}/workbench?draft_key={uuid_v4}` auf. Verwende dafür eine
frisch erzeugte gültige UUIDv4 als `draft_key`. Fehlende, leere, syntaktisch ungültige UUIDs
und UUIDs anderer Versionen (zum Beispiel UUIDv1) führen zu `422 ACTION_REJECTED`. Verwende
denselben `draft_key` für alle Ressourcenaktionen und den anschließenden Teststart, die zu
diesem Entwurf gehören. Für diesen lesenden Aufruf ist kein
`Idempotency-Key` nötig. Verwende nicht `/dynamic-fields` als Ersatz: Die Workbench ist die
maßgebliche, für den jeweiligen API-Nutzer ausführbare Projektkonfiguration.

Die erfolgreiche Antwort liegt unter `data` und enthält insbesondere:

- `bindings`: normale dynamische Eingabefelder. `id` ist die Binding-ID, die später als
  Schlüssel in `values` verwendet wird. Optional kann stattdessen der gelieferte stabile `api_alias` verwendet werden. Beachte `label`, `field_type`, Pflicht-/Toggle-
  Konfiguration und die Zuordnung zu Abschnitten.
- `option_lists`: erlaubte Auswahlwerte für Bindings mit Optionsliste. Erfinde keine Werte,
  sondern verwende ausschließlich die gelieferten Einträge.
- `option_conditions`: Bedingungen, durch die Felder oder Werte abhängig von anderen
  Eingaben verfügbar werden.
- `resources`: Ressourcen-Gruppen und Bild-/Dateifelder. `resources[].fields[]` liefert
  `id` und optional `api_alias`. Bei `/resources/upload` oder `/resources/select`
  verwende `field_id=id` oder `project_id` zusammen mit `field_alias=api_alias`.
- `providers`: die für dieses Projekt aktuell verfügbaren Ausführungsprovider.

Beantworte Fragen wie „Welche Felder hat Projekt 18?“ nicht nur mit dem Endpunkt: Führe den
Workbench-Aufruf aus beziehungsweise gib ihn ausführbar aus und fasse danach die tatsächlich
gelieferten `bindings` und `resources` mit ID, Bezeichnung, Typ, Pflichtstatus und erlaubten
Optionen zusammen. Behaupte keine Felder, die nicht in dieser konkreten Antwort vorkommen.

```bash
curl -k --fail-with-body   -H 'Authorization: Bearer bki_KJXrI-CD4VOkXN2777tyyXSjtWeQTpfAUbhXOaW2ahs'   -H 'Accept: application/json'   'https://bki.flex.immonia.com/api/v1/projects/18/workbench?draft_key=8f6f4c45-8f67-4e0f-90ca-a591f4fe3a31'
```

## Test starten

```bash
curl --fail-with-body \
  -X POST \
  -H 'Authorization: Bearer bki_KJXrI-CD4VOkXN2777tyyXSjtWeQTpfAUbhXOaW2ahs' \
  -H 'Content-Type: application/json' \
  -H 'Idempotency-Key: REPLACE-WITH-A-NEW-UNIQUE-ID' \
  -d '{"provider":"vehabi","values":{}}' \
  'https://bki.flex.immonia.com/api/v1/projects/REPLACE_WITH_PROJECT_ID/runs'
```

Eine erfolgreiche Einzelstart-Antwort hat diese Struktur (gekürzt):

```json
{
  "ok": true,
  "request_id": "3d358e45-2579-4d18-bc77-e09b7bd3fb9d",
  "data": {
    "run": {
      "id": "b34a89fe-3495-4d52-9e41-4790f83a4b1d",
      "project_id": 18,
      "provider": "vehabi",
      "status": "queued"
    },
    "runs": [
      {"id": "b34a89fe-3495-4d52-9e41-4790f83a4b1d", "status": "queued"}
    ],
    "multitest": false,
    "message": "…"
  }
}
```

Verbindliche Ausleseregel:

- Einzelstart: `run_id = response.data.run.id`.
- Multitest/Mehrfachstart: `run_ids = response.data.runs.map(run => run.id)`.
- Verwende niemals `response.run_id`, `response.data.run_id` oder einen HTTP-Header als
  Lauf-ID; diese Felder existieren nicht.
- Falls HTTP 202 vorliegt, aber `data.run.id` fehlt oder keine nichtleere `data.runs[].id`
  vorhanden ist, behandle die Antwort als unerwarteten Vertragsfehler. Bewahre
  `request_id` und den unveränderten `Idempotency-Key` zur Diagnose auf. Starte nicht blind
  mit einem neuen Schlüssel erneut.

Beispiel in JavaScript:

```javascript
const payload = await response.json();
if (!response.ok || !payload.ok) throw new Error(payload.error?.message || `HTTP ${response.status}`);
const runIds = (payload.data?.runs || []).map(run => run?.id).filter(Boolean);
if (!runIds.length && payload.data?.run?.id) runIds.push(payload.data.run.id);
if (!runIds.length) throw new Error(`BKI-Startantwort ohne Lauf-ID; request_id=${payload.request_id || "unbekannt"}`);
```

Statusabfrage für jede gelieferte ID:

```bash
curl -k --fail-with-body   -H 'Authorization: Bearer bki_KJXrI-CD4VOkXN2777tyyXSjtWeQTpfAUbhXOaW2ahs'   -H 'Accept: application/json'   'https://bki.flex.immonia.com/api/v1/runs/REPLACE_WITH_RUN_ID'
```

Die Antwort auf die Statusabfrage enthält den Zustand unter `data.status`, das Ergebnis je
nach Provider unter `data.result_text`, `data.result_images` und `data.result_image_files`
sowie einen Fehler unter `data.error_text`. `queued` und `running` sind nicht final;
`succeeded` und `failed` sind final. Nutze für die Statusabfrage ausschließlich
`GET /runs/{run_id}`, nicht `/projects/{project_id}/runs/{run_id}`.

`values` enthält die Workbench-Feldwerte, indiziert nach Binding-ID oder dem gelieferten `api_alias`. Aliase werden beim Übernehmen bestehender Felder mitgeführt. Unbekannte Aliase und widersprüchliche Werte über Alias und ID sind Fehler; Antworten behalten numerische IDs. Je nach Projekt können zusätzlich `section_texts`, `multitest`, `random_fields`, `aspect_ratio` und `draft_key` verwendet werden. Lade Projektinformationen zuerst und übermittle keine erfundenen Felder.

## Stabile API-Aliase statt wechselnder Feld-IDs

Lade zuerst die Workbench. Jedes Binding liefert `id` und optional `api_alias`.
Verwende einen vorhandenen Alias als Schlüssel in `values`; bei `api_alias=null`
verwendest du weiterhin die numerische ID als Text. Erfinde keine Aliasnamen.

Beispiel (nur verwenden, wenn `farben` und `stil` tatsächlich geliefert werden):

```json
{
  "values": {
    "farben": "#111111\n#e84b13",
    "stil": "traditionelle, handgemalte Plein-Air"
  },
  "section_texts": {}
}
```

- Gilt für `POST /projects/{project_id}/prompt/resolve`, Teststart über
  `POST /projects/{project_id}/runs` und `workbench.save`/`workbench.dispatch`.
- Aliase und numerische IDs dürfen für verschiedene Felder gemischt werden.
  Bestehende ID-Aufrufe bleiben gültig. Antworten und gespeicherte Werte bleiben numerisch.
- Für dasselbe Feld sind ID und Alias nur mit identischen Werten erlaubt.
  Unterschiedliche Werte ergeben `CONFLICTING_API_ALIAS`; unbekannte oder mehrdeutige
  Aliase ergeben `INVALID_API_ALIAS`. Bei Promptauflösung stehen diese Fehler unter
  `data.prompt.errors` und `data.prompt.valid=false` (HTTP 200). Nicht als JSON-Typfehler behandeln.
- Konditionsreferenzen und `random_fields` bleiben numerisch. Uploadfelder unterstützen
  eigene `field_alias`-Parameter; siehe Ressourcenabschnitt.
- Admins vergeben Aliase im Formfeldeditor oder über `dynamic_fields.save` mit
  `api_alias`. Namen: 1–64 Zeichen, Muster `[a-z][a-z0-9_]*`; `constructor` und
  `prototype` sind reserviert. Eindeutig je Projekt und Masterpromptstand.
  Fehlender Parameter erhält den bisherigen Alias; `null` oder leerer Text entfernt ihn.
  Verknüpfungspartner verwenden den Alias des globalen Ausgangsfelds.
- Beim Übernehmen vorhandener Felder auf einen neuen Masterprompt, bei Verfeinerungen
  und Snapshotkopie/-wiederherstellung wird der Alias mitgeführt, auch bei neuer Feld-ID.
  Aliase gelten im aktiven Projektstand. Komplett neue Felder benötigen eine ausdrückliche
  Aliaszuordnung; ältere Snapshots ohne Aliase erhalten keine automatisch erratenen Namen.

## Dateien und Ressourcen einem Test zuordnen

Ressourcen sind immer projektbezogen. `/resources/upload` (multipart) und
`/resources/select` (JSON) akzeptieren entweder die aktuelle `field_id` oder
`project_id` zusammen mit `field_alias`, beispielsweise `makler_logo`.
Die Workbench liefert den optionalen `api_alias` je Ressourcenfeld. Der Alias wird
gegen aktive Uploadfelder des angegebenen Projekts aufgelöst; unbekannte Aliase
oder widersprüchliche Angaben von ID und Alias werden mit HTTP 400 abgewiesen.
Projektberechtigungen, Dateitypen und Quotas gelten unverändert.

Aliase: 1–64 Zeichen, `[a-z][a-z0-9_]*`, keine reservierten Namen `constructor` oder
`prototype`; eindeutig über alle aktiven Uploadgruppen eines Projekts. Eingabefelder
und Uploadfelder besitzen getrennte Alias-Namensräume. Im Admin-Uploadfeld oder über
`dynamic_fields.resource_save` kann `fields[].api_alias` gesetzt werden. Ein fehlender
Alias erhält den bisherigen Wert bei mitgesendeter Feld-ID (alternativ eindeutig
identischer Bezeichnung); leerer Text oder null entfernt ihn. Snapshots und
Projektexport/-import übernehmen die Namen; alte Stände erhalten keine erfundenen Aliase.

Uploadbeispiel: `project_id=18`, `field_alias=makler_logo`, `draft_key=<UUID>` und
`file=<Binärdatei>` als multipart senden. Numerische IDs weiterhin nur aus der
aktuellen Workbench übernehmen; nach einem Snapshotwechsel können sie sich ändern.

Vollständiger Ablauf:

1. Wähle ein Projekt aus `GET /projects`; für Projekt 34 ist `project_id=34`.
2. Erzeuge für den geplanten Test eine neue UUIDv4 als `draft_key`.
3. Rufe `GET /projects/{project_id}/workbench?draft_key={draft_key}` auf. Lies daraus die Ressourcenfelder einschließlich `id`, optionalem `api_alias`, Bezeichnung, Pflichtstatus, erlaubten Dateitypen, Größenlimit und bereits ausgewählter Datei. Gibt es keine Ressourcenfelder, kann diesem Projekt keine Testressource zugeordnet werden; erfinde dann keine ID.
4. Lade für jedes gewünschte Feld genau eine Datei mit `POST /resources/upload` als echtes `multipart/form-data` hoch. Sende `draft_key`, den binären Dateiinhalt `file` und entweder `field_id` oder `project_id` plus `field_alias`. Die Antwort enthält unter anderem Auswahl- und Asset-ID sowie die bestätigte `field_id`.
5. Alternativ: Lade eigene vorhandene Dateien mit `GET /files` und weise eine zulässige Datei mit `POST /resources/select` sowie `asset_id`, demselben `draft_key` und entweder `field_id` oder `project_id` plus `field_alias` zu.
6. Rufe die Workbench erneut mit demselben `draft_key` auf und prüfe, dass alle Pflichtressourcen ausgewählt sind.
7. Starte `POST /projects/{project_id}/runs` mit exakt demselben `draft_key`. Erst dadurch werden die Entwurfsressourcen dauerhaft dem neuen Testlauf zugeordnet.
8. Historische Testressourcen stehen beim Lauf und können über `GET /runs/{run_id}/resources/{file_id}/content` binär abgerufen werden. Verwende dafür die vom Lauf gelieferten Ressourcen-/Datei-IDs.

Beispiel für einen Upload zu Projekt 34 (ersetze `FIELD_ID_FROM_WORKBENCH` durch eine ID aus der Workbench-Antwort von Projekt 34):

```bash
PROJECT_ID=34
DRAFT_KEY="$(uuidgen | tr '[:upper:]' '[:lower:]')"

curl --fail-with-body   -H 'Authorization: Bearer bki_KJXrI-CD4VOkXN2777tyyXSjtWeQTpfAUbhXOaW2ahs'   'https://bki.flex.immonia.com/api/v1/projects/'"$PROJECT_ID"'/workbench?draft_key='"$DRAFT_KEY"

curl --fail-with-body   -X POST   -H 'Authorization: Bearer bki_KJXrI-CD4VOkXN2777tyyXSjtWeQTpfAUbhXOaW2ahs'   -F 'draft_key='"$DRAFT_KEY"   -F 'field_id=FIELD_ID_FROM_WORKBENCH'   -F 'file=@/absolute/path/to/image.jpg'   'https://bki.flex.immonia.com/api/v1/resources/upload'

curl --fail-with-body   -X POST   -H 'Authorization: Bearer bki_KJXrI-CD4VOkXN2777tyyXSjtWeQTpfAUbhXOaW2ahs'   -H 'Content-Type: application/json'   -H 'Idempotency-Key: REPLACE-WITH-A-NEW-UNIQUE-ID'   -d '{"provider":"browsercloud","values":{},"section_texts":{},"draft_key":"'"$DRAFT_KEY"'"}'   'https://bki.flex.immonia.com/api/v1/projects/'"$PROJECT_ID"'/runs'
```

### Upload und Dateiauswahl mit stabilem Alias

Verwende `makler_logo` nur, wenn `resources[].fields[].api_alias` diesen Namen
im gewünschten Projekt liefert. `api_alias` heißt in den Upload-/Select-Requests
`field_alias`; es ist kein Schlüssel in `values`. Bei `api_alias=null` verwende die
aktuelle Feld-ID. Beide Varianten behalten denselben `draft_key` bis zum Teststart.

Alias-Upload (statt des numerischen Upload-Aufrufs oben):

```bash
curl --fail-with-body \
  -H 'Authorization: Bearer bki_KJXrI-CD4VOkXN2777tyyXSjtWeQTpfAUbhXOaW2ahs' \
  -F 'project_id='"$PROJECT_ID" \
  -F 'field_alias=makler_logo' \
  -F 'draft_key='"$DRAFT_KEY" \
  -F 'file=@/absolute/path/to/logo.png' \
  'https://bki.flex.immonia.com/api/v1/resources/upload'
```

Alternativ eine vorhandene eigene Datei auswählen, ohne sie erneut hochzuladen
(ersetze `123` durch eine passende `asset_id` aus `GET /files`; Projekt und UUID
müssen zu deinem aktuellen Entwurf passen):

```http
POST /resources/select
Content-Type: application/json
```

```json
{
  "project_id": 34,
  "field_alias": "makler_logo",
  "asset_id": 123,
  "draft_key": "f971a777-b279-4d4a-a567-8aeb39966417"
}
```

Beide Endpunkte benötigen `resources:write`. Ein nicht vorhandener/mehrdeutiger
Alias, eine fehlende `project_id` zum Alias oder ein widersprüchliches Paar aus
`field_id` und `field_alias` ergibt HTTP 400 mit `error.code=FILE_ACTION_REJECTED`.
Die Erklärung steht in `error.message`. Das unterscheidet sich von Aliasfehlern
normaler Eingabefelder bei `/prompt/resolve`, die als Fachfehler in HTTP 200 kommen.
Antworten enthalten weiterhin die aufgelöste numerische `data.file.field_id`.
Nach Snapshotwechsel die Workbench erneut laden: Erhaltene Aliase werden auf die
aktuell gültige Feld-ID aufgelöst; gelöschte Aliase niemals durch erfundene IDs ersetzen.

Mehrere Bilder für verschiedene Ressourcenfelder werden mit mehreren Upload-Aufrufen,
aber demselben `draft_key`, hochgeladen. Ein erneuter Upload auf dasselbe Feld ersetzt die
Auswahl dieses Feldes im Entwurf. `POST /files` speichert eine Datei nur in der persönlichen
Projektdateibibliothek; erst `/resources/upload` oder `/resources/select` weist sie einem
Ressourcenfeld des Testentwurfs zu.

## Tags bei Testläufen verwenden

Ein Testlauf übernimmt automatisch den **aktuell aktiven persönlichen Tag** des API-Nutzers.
Sende deshalb **weder `tag_id` noch `tag` oder `tag_name` im Body von**
`POST /projects/{project_id}/runs`; diese Felder gehören nicht zum Run-Request und werden
dort nicht ausgewertet. Der beim Start aktive Tag wird mit ID und Name als unveränderlicher
Snapshot am Testlauf gespeichert. Ohne aktiven Tag wird der Testlauf ohne Tag angelegt.

Wenn ein bestimmter Tag verwendet werden soll, führe unmittelbar vor dem Teststart diesen
Workflow aus:

1. `GET /tags` aufrufen und ausschließlich eine dort gelieferte `id` verwenden.
2. Falls der Tag noch nicht existiert: `POST /tags` mit
   `{"name":"Kampagne September","active":true}` aufrufen. Neue Tags sind standardmäßig aktiv.
3. Falls der Tag existiert, aber nicht aktiv ist: `PATCH /tags/{tag_id}` mit
   `{"active":true}` aufrufen. Dadurch werden alle anderen persönlichen Tags automatisch deaktiviert.
4. Erst danach `POST /projects/{project_id}/runs` aufrufen. Für mehrere direkt nacheinander
   gestartete Läufe genügt dieselbe aktive Auswahl, bis sie geändert oder deaktiviert wird.

Zum bewussten Start ohne Tag deaktiviere den aktiven Tag vorher mit
`PATCH /tags/{tag_id}` und `{"active":false}`. Tag-Änderungen und Teststarts sind getrennte
API-Anfragen. Verwende für jede schreibende Anfrage den jeweils erforderlichen eigenen
`Idempotency-Key`.

```bash
# Vorhandenen persönlichen Tag für den nächsten Test aktivieren
curl --fail-with-body   -X PATCH   -H 'Authorization: Bearer bki_KJXrI-CD4VOkXN2777tyyXSjtWeQTpfAUbhXOaW2ahs'   -H 'Content-Type: application/json'   -H 'Idempotency-Key: REPLACE-WITH-A-NEW-UNIQUE-ID'   -d '{"active":true}'   'https://bki.flex.immonia.com/api/v1/tags/'"$TAG_ID"

# Danach den Test wie üblich starten; kein tag_id-Feld mitsenden
curl --fail-with-body   -X POST   -H 'Authorization: Bearer bki_KJXrI-CD4VOkXN2777tyyXSjtWeQTpfAUbhXOaW2ahs'   -H 'Content-Type: application/json'   -H 'Idempotency-Key: REPLACE-WITH-ANOTHER-NEW-UNIQUE-ID'   -d '{"provider":"browsercloud","values":{},"section_texts":{}}'   'https://bki.flex.immonia.com/api/v1/projects/'"$PROJECT_ID"'/runs'
```

## API-Projekt-Tags zur Gruppierung

Verwechsle diese Ressource niemals mit `/tags`: **`/tags` sind persönliche Tags für
Testläufe**, während **`/project-tags` eigenständige, globale Gruppierungsmerkmale für
Projekte** sind. Projekt-Tags sind ausschließlich über die API verfügbar und verändern
weder den aktiven persönlichen Tag noch den Tag-Snapshot eines Testlaufs.

- `GET /project-tags` listet die sichtbaren API-Projekt-Tags.
- `POST /project-tags` mit `{"name":"Immobilien"}` erstellt einen Projekt-Tag (Admin/System).
- `PATCH /project-tags/{project_tag_id}` benennt ihn um (Admin/System).
- `DELETE /project-tags/{project_tag_id}` löscht ihn samt Zuordnungen (Admin/System).
- `GET /projects/{project_id}/project-tags` listet die Tags eines sichtbaren Projekts.
- `PUT /projects/{project_id}/project-tags/{project_tag_id}` ordnet ihn idempotent zu (Admin/System).
- `DELETE /projects/{project_id}/project-tags/{project_tag_id}` entfernt nur die Zuordnung (Admin/System).
- `GET /projects?project_tag_id={project_tag_id}` filtert sichtbare Projekte nach diesem Tag.

Lies IDs immer über `/project-tags`; verwende für diese Endpunkte `project_tag_id` und
niemals die `tag_id` eines persönlichen Testlauf-Tags.

## Lesen und Verwalten

- `GET /me` – eigenes Konto und effektive Scopes
- `GET /projects` – sichtbare Projekte, paginiert
- `GET /projects/{project_id}` – Projektdetails
- `GET /projects/{project_id}/workbench?draft_key={uuid_v4}` – vollständiger Feld-, Provider-, Ressourcen- und Versionskatalog; eine frische UUIDv4 ist Pflicht
- `POST /projects/{project_id}/prompt/resolve` – Eingaben validieren und finalen Prompt anzeigen
- `GET /projects/{project_id}/runs` – Testläufe eines Projekts
- `GET /runs/{run_id}` – Status und Ergebnis eines Testlaufs
- `POST /runs/{run_id}/cancel`, `POST /runs/{run_id}/retry` – Lauf steuern
- `DELETE /runs/{run_id}` – eigenen bzw. berechtigten abgeschlossenen Lauf löschen
- `GET/POST/PATCH/DELETE /files` und `POST /resources/*` – Dateien und Testressourcen verwalten
- `GET/POST /projects/{project_id}/master-prompts` und `POST /projects/{project_id}/master-prompts/{version_id}/activate` – Masterprompts verwalten
- `GET /projects/{project_id}/option-lists`, `GET /projects/{project_id}/dynamic-fields` – Projektkonfiguration laden
- `GET /capabilities` – alle für das Konto freigegebenen erweiterten Aktionen lesen
- `POST /actions/{event}` – eine in `/capabilities` aufgeführte Aktion mit den dort genannten Eingabefeldern ausführen; bei `idempotency_required: true` einen neuen `Idempotency-Key` mitsenden
- `GET /projects/{project_id}/runs/{run_id}/import-preview` und `POST .../import` – Testergebnis prüfen und als neue Masterprompt-Revision übernehmen
- `GET /tags`, `POST /tags`, `PATCH /tags/{tag_id}`, `DELETE /tags/{tag_id}` – persönlichen aktiven Tag verwalten; der aktive Tag wird beim anschließenden Teststart automatisch übernommen
- `GET/POST/PATCH/DELETE /project-tags` und `/projects/{project_id}/project-tags` – getrennte API-only Projektgruppierung; Schreibzugriffe nur für Admin/System
- Admin: Projektanlage/-änderung, Zuweisungen, Nutzerliste und Audit-Logs gemäß Scopes
- Komfort v1.3: Projekte duplizieren/exportieren/importieren, Masterprompt-Versionen archivieren, Optionslisten gesammelt übertragen und dynamische Konfiguration kopieren
- `GET /projects/{project_id}/tester-versions`, `/saved-result-searches`, `/notifications`, `/work-together` und `/profiles/{user_id}` – vollständige REST-Ressourcen
- `GET /runs/{run_id}/events`, `/dashboard/statistics`, `/system/status` – Diagnose, Aktivität und Betriebszustand
- `POST /projects/bulk`, `/results/bulk` – begrenzte Bulkoperationen mit maximal 200 IDs
- `POST /sandbox/validate` – Request schreibfrei prüfen; `GET /meta`, `/changelog`, `/errors` – stabilen API-Vertrag lesen
- `GET /examples?method=...&path=...` – für jede Route cURL-, Python-, JavaScript- und PHP-Grundcode erzeugen; `/developer-assets/...` stellt Collections und SDKs bereit

Bei Cursor-Listen sende den gelieferten `meta.next_cursor` unverändert als `?cursor=...` weiter. Erfinde oder dekodiere Cursor nicht. `limit/offset` bleibt nur für ältere v1-Routen erhalten.

## Antwortformat

Erfolg:

```json
{"ok":true,"request_id":"uuid","data":{},"meta":{"total":0,"limit":50,"offset":0}}
```

Fehler:

```json
{"ok":false,"request_id":"uuid","error":{"code":"ERROR_CODE","message":"Beschreibung"}}
```

Bewahre `request_id` bei Fehlern für die Diagnose auf. Behandle `400` als ungültige Eingabe, `401` als ungültigen Zugang, `403` als fehlenden Scope, `404` als nicht sichtbare Ressource, `409` als Konflikt und `422` als abgelehnten Teststart.

`429 PROJECT_RATE_LIMIT_EXCEEDED` bedeutet, dass das persönliche Kontingent für das
betroffene Projekt im aktuellen 24-Stunden-Fenster verbraucht ist. Lies `project_id`,
`limit`, `remaining`, `reset_at` und `retry_after` aus `error.details`. Warte mindestens
die im `Retry-After`-Header angegebenen Sekunden und sende bis dahin keine automatischen
Wiederholungen für dieses Projekt. Die Antwort enthält außerdem `X-RateLimit-Limit`,
`X-RateLimit-Remaining` und `X-RateLimit-Reset`. Das Limit wird für jedes Projekt separat
gezählt und kann ausschließlich durch einen Administrator geändert werden.

## Sicherheitsregeln

- Niemals den API-Key anzeigen, weitergeben, in Quellcode schreiben oder an fremde Hosts senden.
- Keine destruktive Anfrage ohne ausdrückliche Anweisung des Benutzers ausführen.
- IDs und erlaubte Werte immer aus der API lesen, nicht raten.
- TLS-Zertifikatsfehler dürfen in dieser internen Umgebung ignoriert werden, wenn der verwendete Client dies verlangt.
- Die vollständige maschinenlesbare Vertragsbeschreibung steht unter `https://bki.flex.immonia.com/api/v1/openapi.json`.

## Vollständiger Routenkatalog

Alle Pfade sind relativ zur API-Basis. Ein `Idempotency-Key` ist genau dann Pflicht, wenn er bei der Operation als Pflichtparameter markiert ist.

### `GET /`

API-Einstieg und Dokumentationslinks

- Scope: `public`
- Operation-ID: `get_api_v1`
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1"
```

### `POST /actions/{event}`

Freigegebene BKI-Aktion ausführen

- Scope: `action-specific`
- Operation-ID: `post_actions_by_event`
- Parameter: `event` (path, pflicht), `Idempotency-Key` (header, optional)
- Beispiel-Body: `{"project_id": 1}`
- Fehler: `ACTION_REJECTED, AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"project_id":1}' \
  "https://bki.flex.immonia.com/api/v1/actions/profile.get"
```

### `GET /admin/audit-logs`

API-Audit-Logs lesen

- Scope: `audit:read`
- Operation-ID: `get_admin_audit_logs`
- Parameter: `limit` (query, optional), `cursor` (query, optional), `offset` (query, optional)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/admin/audit-logs"
```

### `GET /admin/settings`

Provider- und Bildverarbeitungseinstellungen lesen

- Scope: `settings:read`
- Operation-ID: `get_admin_settings`
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/admin/settings"
```

### `GET /admin/users`

Nutzer auflisten

- Scope: `users:read`
- Operation-ID: `get_admin_users`
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/admin/users"
```

### `GET /capabilities`

Verfügbare API-Aktionen und Scopes lesen

- Scope: `profile:read`
- Operation-ID: `get_capabilities`
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/capabilities"
```

### `GET /changelog`

API-Changelog lesen

- Scope: `public`
- Operation-ID: `get_changelog`
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/changelog"
```

### `GET /dashboard/statistics`

Dashboard-Kennzahlen und Aktivitäten lesen

- Scope: `system:read`
- Operation-ID: `get_dashboard_statistics`
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/dashboard/statistics"
```

### `GET /developer-assets/{asset}`

Collections und SDKs herunterladen

- Scope: `public`
- Operation-ID: `get_developer_assets_by_asset`
- Parameter: `asset` (path, pflicht)
- Fehler: `ASSET_NOT_FOUND, AUTH_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/developer-assets/postman"
```

### `GET /errors`

Stabile Fehlercodes lesen

- Scope: `public`
- Operation-ID: `get_errors`
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/errors"
```

### `GET /examples`

cURL-, Python-, JavaScript- und PHP-Beispiel für jede Route erzeugen

- Scope: `public`
- Operation-ID: `get_examples`
- Parameter: `method` (query, optional), `path` (query, optional)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/examples"
```

### `GET /files`

Eigene Projektdateien laden

- Scope: `files:read`
- Operation-ID: `get_files`
- Fehler: `AUTH_REQUIRED, FILE_NOT_FOUND, INTERNAL_ERROR, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/files"
```

### `POST /files`

Projektdatei hochladen

- Scope: `files:write`
- Operation-ID: `post_files`
- Beispiel-Body: `{"file": "@/path/to/file.png", "project_id": 1}`
- Fehler: `AUTH_REQUIRED, FILE_NOT_FOUND, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -F "project_id=1" \
  -F "file=@/path/to/file.png" \
  "https://bki.flex.immonia.com/api/v1/files"
```

### `DELETE /files/{file_id}`

Projektdatei archivieren

- Scope: `files:write`
- Operation-ID: `delete_files_by_file_id`
- Parameter: `file_id` (path, pflicht)
- Beispiel-Body: `{"archived": true}`
- Fehler: `AUTH_REQUIRED, FILE_NOT_FOUND, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X DELETE -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"archived":true}' \
  "https://bki.flex.immonia.com/api/v1/files/1"
```

### `PATCH /files/{file_id}`

Projektdatei umbenennen

- Scope: `files:write`
- Operation-ID: `patch_files_by_file_id`
- Parameter: `file_id` (path, pflicht)
- Beispiel-Body: `{"name": "briefing.png"}`
- Fehler: `AUTH_REQUIRED, FILE_NOT_FOUND, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X PATCH -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"name":"briefing.png"}' \
  "https://bki.flex.immonia.com/api/v1/files/1"
```

### `GET /files/{file_id}/content`

Dateiinhalt herunterladen oder anzeigen

- Scope: `files:read`
- Operation-ID: `get_files_by_file_id_content`
- Parameter: `file_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, FILE_NOT_FOUND, INTERNAL_ERROR, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/files/1/content"
```

### `GET /me`

Eigenes Konto und Scopes lesen

- Scope: `profile:read`
- Operation-ID: `get_me`
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/me"
```

### `PATCH /me/avatar`

Eigenen Avatar verwalten

- Scope: `profile:write`
- Operation-ID: `patch_me_avatar`
- Parameter: `Idempotency-Key` (header, pflicht)
- Beispiel-Body: `{"preset": "avatar-1"}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X PATCH -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Idempotency-Key: unique-request-001" \
  -d '{"preset":"avatar-1"}' \
  "https://bki.flex.immonia.com/api/v1/me/avatar"
```

### `GET /meta`

Versionierungs- und Deprecation-Regeln lesen

- Scope: `public`
- Operation-ID: `get_meta`
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/meta"
```

### `GET /notifications`

Benachrichtigungen mit Cursor lesen

- Scope: `profile:read`
- Operation-ID: `get_notifications`
- Parameter: `cursor` (query, optional), `limit` (query, optional)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/notifications"
```

### `POST /notifications/read`

Benachrichtigungen als gelesen markieren

- Scope: `profile:write`
- Operation-ID: `post_notifications_read`
- Parameter: `Idempotency-Key` (header, pflicht)
- Beispiel-Body: `{"ids": [1]}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Idempotency-Key: unique-request-001" \
  -d '{"ids":[1]}' \
  "https://bki.flex.immonia.com/api/v1/notifications/read"
```

### `GET /openapi.json`

OpenAPI-Vertrag laden

- Scope: `public`
- Operation-ID: `get_openapi_json`
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/openapi.json"
```

### `GET /profiles/{user_id}`

Öffentliches internes Profil lesen

- Scope: `profile:read`
- Operation-ID: `get_profiles_by_user_id`
- Parameter: `user_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, PROFILE_NOT_FOUND, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/profiles/1"
```

### `GET /project-tags`

API-Projekt-Tags auflisten

- Scope: `project_tags:read`
- Operation-ID: `get_project_tags`
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, PROJECT_TAG_NOT_FOUND, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/project-tags"
```

### `POST /project-tags`

API-Projekt-Tag erstellen

- Scope: `project_tags:write`
- Operation-ID: `post_project_tags`
- Beispiel-Body: `{"name": "Kampagne"}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_TAG_NOT_FOUND, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"name":"Kampagne"}' \
  "https://bki.flex.immonia.com/api/v1/project-tags"
```

### `DELETE /project-tags/{project_tag_id}`

API-Projekt-Tag löschen

- Scope: `project_tags:write`
- Operation-ID: `delete_project_tags_by_project_tag_id`
- Parameter: `project_tag_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_TAG_NOT_FOUND, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X DELETE -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/project-tags/1"
```

### `PATCH /project-tags/{project_tag_id}`

API-Projekt-Tag umbenennen

- Scope: `project_tags:write`
- Operation-ID: `patch_project_tags_by_project_tag_id`
- Parameter: `project_tag_id` (path, pflicht)
- Beispiel-Body: `{"name": "Kampagne 2026"}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_TAG_NOT_FOUND, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X PATCH -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"name":"Kampagne 2026"}' \
  "https://bki.flex.immonia.com/api/v1/project-tags/1"
```

### `GET /projects`

Sichtbare Projekte auflisten

- Scope: `projects:read`
- Operation-ID: `get_projects`
- Parameter: `limit` (query, optional), `cursor` (query, optional), `offset` (query, optional), `project_tag_id` (query, optional)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_NOT_FOUND, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/projects"
```

### `POST /projects`

Projekt erstellen

- Scope: `projects:write`
- Operation-ID: `post_projects`
- Parameter: `Idempotency-Key` (header, pflicht)
- Beispiel-Body: `{"active": true, "description": "example", "lead_user_id": 1, "name": "API-Beispiel", "result_filename_pattern": "example"}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_NOT_FOUND, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Idempotency-Key: unique-request-001" \
  -d '{"name":"API-Beispiel","lead_user_id":1,"description":"example","active":true,"result_filename_pattern":"example"}' \
  "https://bki.flex.immonia.com/api/v1/projects"
```

### `POST /projects/bulk`

Projekte gesammelt aktivieren/deaktivieren

- Scope: `projects:write`
- Operation-ID: `post_projects_bulk`
- Parameter: `Idempotency-Key` (header, pflicht)
- Beispiel-Body: `{"ids": [1, 2], "operation": "activate"}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Idempotency-Key: unique-request-001" \
  -d '{"ids":[1,2],"operation":"activate"}' \
  "https://bki.flex.immonia.com/api/v1/projects/bulk"
```

### `POST /projects/import`

Projekt-Snapshot sicher importieren

- Scope: `projects:write`
- Operation-ID: `post_projects_import`
- Parameter: `Idempotency-Key` (header, pflicht)
- Beispiel-Body: `{"lead_user_id": 1, "name": "Importiertes Projekt", "snapshot": {"project": {"name": "Projekt"}}}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Idempotency-Key: unique-request-001" \
  -d '{"name":"Importiertes Projekt","lead_user_id":1,"snapshot":{"project":{"name":"Projekt"}}}' \
  "https://bki.flex.immonia.com/api/v1/projects/import"
```

### `GET /projects/{project_id}`

Projekt lesen

- Scope: `projects:read`
- Operation-ID: `get_projects_by_project_id`
- Parameter: `project_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/projects/1"
```

### `PATCH /projects/{project_id}`

Projekt ändern

- Scope: `projects:write`
- Operation-ID: `patch_projects_by_project_id`
- Parameter: `project_id` (path, pflicht)
- Beispiel-Body: `{"active": true, "description": "Beschreibung", "lead_user_id": 1, "name": "Projektname"}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X PATCH -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"name":"Projektname","description":"Beschreibung","active":true,"lead_user_id":1}' \
  "https://bki.flex.immonia.com/api/v1/projects/1"
```

### `GET /projects/{project_id}/assignments`

Projektzuweisungen lesen

- Scope: `projects:read`
- Operation-ID: `get_projects_by_project_id_assignments`
- Parameter: `project_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/projects/1/assignments"
```

### `POST /projects/{project_id}/assignments`

Tester zuweisen

- Scope: `assignments:write`
- Operation-ID: `post_projects_by_project_id_assignments`
- Parameter: `project_id` (path, pflicht)
- Beispiel-Body: `{"user_id": 1}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"user_id":1}' \
  "https://bki.flex.immonia.com/api/v1/projects/1/assignments"
```

### `DELETE /projects/{project_id}/assignments/{user_id}`

Testerzuweisung entfernen

- Scope: `assignments:write`
- Operation-ID: `delete_projects_by_project_id_assignments_by_user_id`
- Parameter: `project_id` (path, pflicht), `user_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X DELETE -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/projects/1/assignments/1"
```

### `POST /projects/{project_id}/duplicate`

Projekt samt Konfiguration duplizieren

- Scope: `projects:write`
- Operation-ID: `post_projects_by_project_id_duplicate`
- Parameter: `Idempotency-Key` (header, pflicht), `project_id` (path, pflicht)
- Beispiel-Body: `{"active": false, "lead_user_id": 1, "name": "Projekt - Kopie"}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Idempotency-Key: unique-request-001" \
  -d '{"name":"Projekt - Kopie","active":false,"lead_user_id":1}' \
  "https://bki.flex.immonia.com/api/v1/projects/1/duplicate"
```

### `GET /projects/{project_id}/dynamic-configuration`

Vollständige dynamische Konfiguration exportieren

- Scope: `dynamic_fields:read`
- Operation-ID: `get_projects_by_project_id_dynamic_configuration`
- Parameter: `project_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/projects/1/dynamic-configuration"
```

### `POST /projects/{project_id}/dynamic-configuration/copy`

Dynamische Konfiguration aus Projekt kopieren

- Scope: `dynamic_fields:write`
- Operation-ID: `post_projects_by_project_id_dynamic_configuration_copy`
- Parameter: `Idempotency-Key` (header, pflicht), `project_id` (path, pflicht)
- Beispiel-Body: `{"source_project_id": 1}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Idempotency-Key: unique-request-001" \
  -d '{"source_project_id":1}' \
  "https://bki.flex.immonia.com/api/v1/projects/1/dynamic-configuration/copy"
```

### `GET /projects/{project_id}/dynamic-fields`

Dynamische Felder und Bedingungen laden

- Scope: `dynamic_fields:read`
- Operation-ID: `get_projects_by_project_id_dynamic_fields`
- Parameter: `project_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/projects/1/dynamic-fields"
```

### `GET /projects/{project_id}/export`

Vollständigen Projekt-Snapshot exportieren

- Scope: `projects:read`
- Operation-ID: `get_projects_by_project_id_export`
- Parameter: `project_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/projects/1/export"
```

### `GET /projects/{project_id}/image`

Projektbild herunterladen

- Scope: `projects:read`
- Operation-ID: `get_projects_by_project_id_image`
- Parameter: `project_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/projects/1/image"
```

### `POST /projects/{project_id}/image`

Projektbild hochladen oder entfernen

- Scope: `projects:write`
- Operation-ID: `post_projects_by_project_id_image`
- Parameter: `project_id` (path, pflicht)
- Beispiel-Body: `{"image": "@/path/to/file.png", "remove": true}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -F "image=@/path/to/file.png" \
  -F "remove=True" \
  "https://bki.flex.immonia.com/api/v1/projects/1/image"
```

### `GET /projects/{project_id}/master-prompt-versions`

Masterprompt-Versionen als Ressourcen lesen

- Scope: `master_prompts:read`
- Operation-ID: `get_projects_by_project_id_master_prompt_versions`
- Parameter: `project_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VERSION_NOT_FOUND`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/projects/1/master-prompt-versions"
```

### `PATCH /projects/{project_id}/master-prompt-versions/{version_id}`

Masterprompt-Version archivieren oder wiederherstellen

- Scope: `master_prompts:write`
- Operation-ID: `patch_projects_by_project_id_master_prompt_versions_by_version_id`
- Parameter: `Idempotency-Key` (header, pflicht), `project_id` (path, pflicht), `version_id` (path, pflicht)
- Beispiel-Body: `{"archived": true}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR, VERSION_NOT_FOUND`

```bash
curl -k -X PATCH -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Idempotency-Key: unique-request-001" \
  -d '{"archived":true}' \
  "https://bki.flex.immonia.com/api/v1/projects/1/master-prompt-versions/1"
```

### `GET /projects/{project_id}/master-prompts`

Masterprompt-Versionen laden

- Scope: `master_prompts:read`
- Operation-ID: `get_projects_by_project_id_master_prompts`
- Parameter: `project_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VERSION_NOT_FOUND`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/projects/1/master-prompts"
```

### `POST /projects/{project_id}/master-prompts`

Masterprompt prüfen und importieren

- Scope: `master_prompts:write`
- Operation-ID: `post_projects_by_project_id_master_prompts`
- Parameter: `project_id` (path, pflicht), `Idempotency-Key` (header, pflicht)
- Beispiel-Body: `{"prompt": "# Masterprompt\n..."}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR, VERSION_NOT_FOUND`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Idempotency-Key: unique-request-001" \
  -d '{"prompt":"# Masterprompt\n..."}' \
  "https://bki.flex.immonia.com/api/v1/projects/1/master-prompts"
```

### `POST /projects/{project_id}/master-prompts/{version_id}/activate`

Masterprompt-Version aktivieren

- Scope: `master_prompts:activate`
- Operation-ID: `post_projects_by_project_id_master_prompts_by_version_id_activate`
- Parameter: `project_id` (path, pflicht), `version_id` (path, pflicht), `Idempotency-Key` (header, pflicht)
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR, VERSION_NOT_FOUND`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Idempotency-Key: unique-request-001" \
  "https://bki.flex.immonia.com/api/v1/projects/1/master-prompts/1/activate"
```

### `GET /projects/{project_id}/option-lists`

Optionslisten laden

- Scope: `options:read`
- Operation-ID: `get_projects_by_project_id_option_lists`
- Parameter: `project_id` (path, pflicht), `master_version_id` (query, optional)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/projects/1/option-lists"
```

### `GET /projects/{project_id}/option-lists/export`

Alle Optionslisten als JSON exportieren

- Scope: `options:read`
- Operation-ID: `get_projects_by_project_id_option_lists_export`
- Parameter: `project_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/projects/1/option-lists/export"
```

### `POST /projects/{project_id}/option-lists/import`

Mehrere Optionslisten importieren

- Scope: `options:write`
- Operation-ID: `post_projects_by_project_id_option_lists_import`
- Parameter: `Idempotency-Key` (header, pflicht), `project_id` (path, pflicht)
- Beispiel-Body: `{"items": [{"list_type": "simple", "name": "Zielgruppe", "values": [{"value_text": "B2B"}]}]}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Idempotency-Key: unique-request-001" \
  -d '{"items":[{"name":"Zielgruppe","list_type":"simple","values":[{"value_text":"B2B"}]}]}' \
  "https://bki.flex.immonia.com/api/v1/projects/1/option-lists/import"
```

### `GET /projects/{project_id}/project-tags`

API-Projekt-Tags eines Projekts lesen

- Scope: `project_tags:read`
- Operation-ID: `get_projects_by_project_id_project_tags`
- Parameter: `project_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, PROJECT_TAG_NOT_FOUND, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/projects/1/project-tags"
```

### `DELETE /projects/{project_id}/project-tags/{project_tag_id}`

API-Projekt-Tag-Zuordnung entfernen

- Scope: `project_tags:write`
- Operation-ID: `delete_projects_by_project_id_project_tags_by_project_tag_id`
- Parameter: `project_id` (path, pflicht), `project_tag_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, PROJECT_TAG_NOT_FOUND, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X DELETE -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/projects/1/project-tags/1"
```

### `PUT /projects/{project_id}/project-tags/{project_tag_id}`

API-Projekt-Tag zuordnen

- Scope: `project_tags:write`
- Operation-ID: `put_projects_by_project_id_project_tags_by_project_tag_id`
- Parameter: `project_id` (path, pflicht), `project_tag_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, PROJECT_TAG_NOT_FOUND, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X PUT -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/projects/1/project-tags/1"
```

### `POST /projects/{project_id}/prompt/resolve`

Prompt prüfen und vollständig auflösen

- Scope: `workbench:read`
- Operation-ID: `post_projects_by_project_id_prompt_resolve`
- Parameter: `project_id` (path, pflicht)
- Beispiel-Body: `{"section_texts": {}, "values": {"104": "Beispielwert"}}`
- Fehler: `ACTION_REJECTED, AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"values":{"104":"Beispielwert"},"section_texts":{}}' \
  "https://bki.flex.immonia.com/api/v1/projects/1/prompt/resolve"
```

### `GET /projects/{project_id}/runs`

Testläufe eines Projekts auflisten

- Scope: `runs:read`
- Operation-ID: `get_projects_by_project_id_runs`
- Parameter: `project_id` (path, pflicht), `limit` (query, optional), `cursor` (query, optional), `offset` (query, optional)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, RUN_NOT_FOUND, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/projects/1/runs"
```

### `POST /projects/{project_id}/runs`

Test starten

- Scope: `runs:start`
- Operation-ID: `post_projects_by_project_id_runs`
- Parameter: `project_id` (path, pflicht), `Idempotency-Key` (header, pflicht)
- Beispiel-Body: `{"draft_key": "00000000-0000-4000-8000-000000000001", "provider": "browsercloud", "section_texts": {}, "values": {}}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, RUN_NOT_FOUND, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Idempotency-Key: unique-request-001" \
  -d '{"provider":"browsercloud","values":{},"section_texts":{},"draft_key":"00000000-0000-4000-8000-000000000001"}' \
  "https://bki.flex.immonia.com/api/v1/projects/1/runs"
```

### `GET /projects/{project_id}/runs/{run_id}/analysis`

Ergebnis mit Variablen und Masterprompt-Diff analysieren

- Scope: `results:read`
- Operation-ID: `get_projects_by_project_id_runs_by_run_id_analysis`
- Parameter: `project_id` (path, pflicht), `run_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, RUN_NOT_FOUND, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/projects/1/runs/00000000-0000-4000-8000-000000000001/analysis"
```

### `POST /projects/{project_id}/runs/{run_id}/import`

Testergebnis in eine neue Masterprompt-Revision importieren

- Scope: `results:import`
- Operation-ID: `post_projects_by_project_id_runs_by_run_id_import`
- Parameter: `project_id` (path, pflicht), `run_id` (path, pflicht), `Idempotency-Key` (header, pflicht)
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, RUN_NOT_FOUND, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Idempotency-Key: unique-request-001" \
  "https://bki.flex.immonia.com/api/v1/projects/1/runs/00000000-0000-4000-8000-000000000001/import"
```

### `GET /projects/{project_id}/runs/{run_id}/import-preview`

Ergebnisimport vollständig vorprüfen

- Scope: `results:import`
- Operation-ID: `get_projects_by_project_id_runs_by_run_id_import_preview`
- Parameter: `project_id` (path, pflicht), `run_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, RUN_NOT_FOUND, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/projects/1/runs/00000000-0000-4000-8000-000000000001/import-preview"
```

### `GET /projects/{project_id}/saved-result-searches`

Gespeicherte Ergebnissuchen als JSON verwalten

- Scope: `results:read`
- Operation-ID: `get_projects_by_project_id_saved_result_searches`
- Parameter: `project_id` (path, pflicht), `cursor` (query, optional), `limit` (query, optional)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/projects/1/saved-result-searches"
```

### `POST /projects/{project_id}/saved-result-searches`

Gespeicherte Ergebnissuchen als JSON verwalten

- Scope: `results:read`
- Operation-ID: `post_projects_by_project_id_saved_result_searches`
- Parameter: `Idempotency-Key` (header, pflicht), `project_id` (path, pflicht)
- Beispiel-Body: `{"criteria": {"status": "succeeded"}, "name": "Erfolgreiche Tests"}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Idempotency-Key: unique-request-001" \
  -d '{"name":"Erfolgreiche Tests","criteria":{"status":"succeeded"}}' \
  "https://bki.flex.immonia.com/api/v1/projects/1/saved-result-searches"
```

### `GET /projects/{project_id}/tester-versions`

Tester-Versionen mit Cursor auflisten

- Scope: `workbench:read`
- Operation-ID: `get_projects_by_project_id_tester_versions`
- Parameter: `project_id` (path, pflicht), `cursor` (query, optional), `limit` (query, optional)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VERSION_NOT_FOUND`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/projects/1/tester-versions"
```

### `GET /projects/{project_id}/workbench`

Vollständige Workbench-Konfiguration laden

- Scope: `workbench:read`
- Operation-ID: `get_projects_by_project_id_workbench`
- Parameter: `project_id` (path, pflicht), `draft_key` (query, pflicht)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/projects/1/workbench?draft_key=8f6f4c45-8f67-4e0f-90ca-a591f4fe3a31"
```

### `POST /resources/delete`

Datei aus einem Testentwurf entfernen

- Scope: `resources:write`
- Operation-ID: `post_resources_delete`
- Beispiel-Body: `{"selection_id": 1}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"selection_id":1}' \
  "https://bki.flex.immonia.com/api/v1/resources/delete"
```

### `POST /resources/reset-draft`

Alle Ressourcen eines Entwurfs zurücksetzen

- Scope: `resources:write`
- Operation-ID: `post_resources_reset_draft`
- Beispiel-Body: `{"draft_key": "00000000-0000-4000-8000-000000000001"}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"draft_key":"00000000-0000-4000-8000-000000000001"}' \
  "https://bki.flex.immonia.com/api/v1/resources/reset-draft"
```

### `POST /resources/restore-version`

Ressourcen einer Testversion wiederherstellen

- Scope: `resources:write`
- Operation-ID: `post_resources_restore_version`
- Beispiel-Body: `{"draft_key": "00000000-0000-4000-8000-000000000002", "run_id": "00000000-0000-4000-8000-000000000001"}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"run_id":"00000000-0000-4000-8000-000000000001","draft_key":"00000000-0000-4000-8000-000000000002"}' \
  "https://bki.flex.immonia.com/api/v1/resources/restore-version"
```

### `POST /resources/select`

Vorhandene Datei einem Ressourcenfeld zuweisen

- Scope: `resources:write`
- Operation-ID: `post_resources_select`
- Beispiel-Body: `{"asset_id": 1, "draft_key": "00000000-0000-4000-8000-000000000001", "field_id": 1}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"asset_id":1,"field_id":1,"draft_key":"00000000-0000-4000-8000-000000000001"}' \
  "https://bki.flex.immonia.com/api/v1/resources/select"
```

### `POST /resources/upload`

Datei hochladen und einem Ressourcenfeld zuweisen

- Scope: `resources:write`
- Operation-ID: `post_resources_upload`
- Beispiel-Body: `{"draft_key": "8f6f4c45-8f67-4e0f-90ca-a591f4fe3a31", "field_id": 1, "file": "@/path/to/file.png"}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -F "draft_key=8f6f4c45-8f67-4e0f-90ca-a591f4fe3a31" \
  -F "file=@/path/to/file.png" \
  -F "field_id=1" \
  "https://bki.flex.immonia.com/api/v1/resources/upload"
```

### `GET /result-images/{image_id}/content`

Ergebnisbild als Originaldatei laden

- Scope: `runs:read`
- Operation-ID: `get_result_images_by_image_id_content`
- Parameter: `image_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/result-images/1/content"
```

### `GET /result-images/{image_id}/content/{filename}`

Ergebnisbild als Originaldatei laden

- Scope: `runs:read`
- Operation-ID: `get_result_images_by_image_id_content_by_filename`
- Parameter: `image_id` (path, pflicht), `filename` (path, pflicht)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/result-images/1/content/1"
```

### `POST /results/bulk`

Ergebnisse gesammelt bearbeiten

- Scope: `runs:delete`
- Operation-ID: `post_results_bulk`
- Parameter: `Idempotency-Key` (header, pflicht)
- Beispiel-Body: `{"operation": "delete", "project_id": 1, "run_ids": ["00000000-0000-4000-8000-000000000001"]}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Idempotency-Key: unique-request-001" \
  -d '{"project_id":1,"run_ids":["00000000-0000-4000-8000-000000000001"],"operation":"delete"}' \
  "https://bki.flex.immonia.com/api/v1/results/bulk"
```

### `DELETE /runs/{run_id}`

Abgeschlossenen Testlauf löschen

- Scope: `runs:delete`
- Operation-ID: `delete_runs_by_run_id`
- Parameter: `run_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_RATE_LIMIT_EXCEEDED, RUN_NOT_FOUND, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X DELETE -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/runs/00000000-0000-4000-8000-000000000001"
```

### `GET /runs/{run_id}`

Teststatus und Ergebnis lesen

- Scope: `runs:read`
- Operation-ID: `get_runs_by_run_id`
- Parameter: `run_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_RATE_LIMIT_EXCEEDED, RUN_NOT_FOUND, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/runs/00000000-0000-4000-8000-000000000001"
```

### `POST /runs/{run_id}/cancel`

Aktiven Testlauf abbrechen

- Scope: `runs:cancel`
- Operation-ID: `post_runs_by_run_id_cancel`
- Parameter: `run_id` (path, pflicht), `Idempotency-Key` (header, pflicht)
- Beispiel-Body: `{"draft_key": "00000000-0000-4000-8000-000000000001", "project_id": 1}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_RATE_LIMIT_EXCEEDED, RUN_NOT_FOUND, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Idempotency-Key: unique-request-001" \
  -d '{"project_id":1,"draft_key":"00000000-0000-4000-8000-000000000001"}' \
  "https://bki.flex.immonia.com/api/v1/runs/00000000-0000-4000-8000-000000000001/cancel"
```

### `GET /runs/{run_id}/events`

Sanitisierte Run-Diagnoseereignisse lesen

- Scope: `runs:read`
- Operation-ID: `get_runs_by_run_id_events`
- Parameter: `run_id` (path, pflicht), `cursor` (query, optional), `limit` (query, optional)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_RATE_LIMIT_EXCEEDED, RUN_NOT_FOUND, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/runs/00000000-0000-4000-8000-000000000001/events"
```

### `GET /runs/{run_id}/resources/{file_id}/content`

Historische Testressource herunterladen

- Scope: `resources:read`
- Operation-ID: `get_runs_by_run_id_resources_by_file_id_content`
- Parameter: `run_id` (path, pflicht), `file_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_RATE_LIMIT_EXCEEDED, RUN_NOT_FOUND, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/runs/00000000-0000-4000-8000-000000000001/resources/1/content"
```

### `POST /runs/{run_id}/retry`

Fehlgeschlagenen Ergebnisabruf wiederholen

- Scope: `runs:retry`
- Operation-ID: `post_runs_by_run_id_retry`
- Parameter: `run_id` (path, pflicht), `Idempotency-Key` (header, pflicht)
- Beispiel-Body: `{"project_id": 1}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_RATE_LIMIT_EXCEEDED, RUN_NOT_FOUND, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Idempotency-Key: unique-request-001" \
  -d '{"project_id":1}' \
  "https://bki.flex.immonia.com/api/v1/runs/00000000-0000-4000-8000-000000000001/retry"
```

### `POST /sandbox/validate`

Request schreibfrei im Testmodus validieren

- Scope: `profile:read`
- Operation-ID: `post_sandbox_validate`
- Parameter: `Idempotency-Key` (header, pflicht)
- Beispiel-Body: `{"body": {"name": "Vorschau"}, "method": "POST", "path": "/projects"}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Idempotency-Key: unique-request-001" \
  -d '{"method":"POST","path":"/projects","body":{"name":"Vorschau"}}' \
  "https://bki.flex.immonia.com/api/v1/sandbox/validate"
```

### `GET /system/status`

Queue-, Worker-, Bridge- und Gatewaystatus lesen

- Scope: `system:read`
- Operation-ID: `get_system_status`
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/system/status"
```

### `GET /tags`

Persönliche Tags auflisten

- Scope: `tags:read`
- Operation-ID: `get_tags`
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN, TAG_NOT_FOUND`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/tags"
```

### `POST /tags`

Persönlichen Tag erstellen

- Scope: `tags:write`
- Operation-ID: `post_tags`
- Beispiel-Body: `{"active": true, "name": "Favorit"}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN, TAG_NOT_FOUND, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"name":"Favorit","active":true}' \
  "https://bki.flex.immonia.com/api/v1/tags"
```

### `DELETE /tags/{tag_id}`

Persönlichen Tag löschen

- Scope: `tags:write`
- Operation-ID: `delete_tags_by_tag_id`
- Parameter: `tag_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN, TAG_NOT_FOUND, VALIDATION_ERROR`

```bash
curl -k -X DELETE -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/tags/1"
```

### `PATCH /tags/{tag_id}`

Persönlichen Tag ändern

- Scope: `tags:write`
- Operation-ID: `patch_tags_by_tag_id`
- Parameter: `tag_id` (path, pflicht)
- Beispiel-Body: `{"active": true, "name": "Wichtig"}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN, TAG_NOT_FOUND, VALIDATION_ERROR`

```bash
curl -k -X PATCH -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"name":"Wichtig","active":true}' \
  "https://bki.flex.immonia.com/api/v1/tags/1"
```

### `GET /tester-versions/{version_id}`

Tester-Version vollständig lesen

- Scope: `workbench:read`
- Operation-ID: `get_tester_versions_by_version_id`
- Parameter: `version_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VERSION_NOT_FOUND`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/tester-versions/1"
```

### `GET /work-together`

Work-together-Anfragen lesen und erstellen

- Scope: `projects:read`
- Operation-ID: `get_work_together`
- Fehler: `AUTH_REQUIRED, COLLABORATION_NOT_FOUND, INTERNAL_ERROR, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "https://bki.flex.immonia.com/api/v1/work-together"
```

### `POST /work-together`

Work-together-Anfragen lesen und erstellen

- Scope: `projects:read`
- Operation-ID: `post_work_together`
- Parameter: `Idempotency-Key` (header, pflicht)
- Beispiel-Body: `{"project_id": 1, "user_id": 2}`
- Fehler: `AUTH_REQUIRED, COLLABORATION_NOT_FOUND, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Idempotency-Key: unique-request-001" \
  -d '{"project_id":1,"user_id":2}' \
  "https://bki.flex.immonia.com/api/v1/work-together"
```

### `PATCH /work-together/{collaboration_id}`

Work-together-Anfrage beantworten

- Scope: `projects:write`
- Operation-ID: `patch_work_together_by_collaboration_id`
- Parameter: `Idempotency-Key` (header, pflicht), `collaboration_id` (path, pflicht)
- Beispiel-Body: `{"status": "accepted"}`
- Fehler: `AUTH_REQUIRED, COLLABORATION_NOT_FOUND, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X PATCH -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Idempotency-Key: unique-request-001" \
  -d '{"status":"accepted"}' \
  "https://bki.flex.immonia.com/api/v1/work-together/1"
```
