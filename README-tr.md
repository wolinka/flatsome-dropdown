[🇹🇷 Türkçe (Turkish)](README-tr.md) | [🇬🇧 English](README.md)

# Flatsome Classic Dropdown Plugin

Flatsome temasının karmaşık "mega menü" yapısını, kullanıma hazır, temiz ve klasik çok seviyeli (multi-level) bir açılır menüyle (dropdown) değiştiren hafif bir WordPress eklentisi.

## 🚀 Özellikler

* **Klasik Çok Seviyeli Dropdown'lar:** Flatsome'ın sabit mega-menü mimarisini devreden çıkararak, iç içe limitsiz seviyede çalışan pürüzsüz ve temiz bir açılır menü hiyerarşisi oluşturur.
* **Flatsome Customizer ile %100 Uyum:** Flatsome'ın kendi arayüzündeki **All Dropdowns** ve **Default Dropdowns** panelleriyle tamamen eşzamanlı çalışır. Arka plan rengi, kavisler, gölgelendirme, metin rengi (Açık/Koyu mod) ve boyut tercihlerinizi okuyarak doğrudan menünüze yansıtır.
* **Özel "Dropdown Width (Genişlik)" Ayarı:** Flatsome Customizer'ındaki `Header -> Dropdown Style` menüsüne yepyeni bir "Dropdown Width (px)" ayarı ekler. Böylece standart kutu genişliklerini kolaylıkla panelden belirleyebilirsiniz.
* **Akıllı Mobil Uyumluluk:** Eklenti sadece masaüstü menülerde devreye girer. Flatsome'ın kendisine has "Off-Canvas Mobil Akordiyon" menü yapısına `(FlatsomeNavSidebar)` veya mobile dokunmaz, böylece temanın şık mobil deneyimini bozmaz.
* **Tam Güvenli Mimari:** `wp_kses_post`, `esc_attr` ve katı URL süzgeçleri gibi üst düzey WordPress CSS/XSS veri güvenlik standartları referans alınarak yazılmıştır. RGBA/HEX renk dönüşüm süzgeçleri ve yazar izin denetimleri (`edit_theme_options`) uygulanmıştır.

## ⚙️ Kurulum 

1. Bu repoyu bilgisayarınıza indirin veya klonlayın (`git clone`).
2. `flatsome-dropdown` klasörünü WordPress kurulumunuzun dizininde yer alan `/wp-content/plugins/` klasörüne yükleyin.
3. WordPress panelindeki **Eklentiler** (Plugins) menüsünden eklentiyi "Etkinleştir"in.
4. *(İsteğe bağlı ancak tavsiye)* **Görünüm > Özelleştir > Header > Dropdown Style** yolunu izleyerek renk, gölgelendirme ve "Dropdown Width" (genişlik) değerlerinizi belirleyin!

## 🔧 Nasıl Çalışıyor?

Eklenti aktifleştiğinde, Flatsome'ın masaüstü Header menülerindeki varsayılan HTML düzenleyiciyi (`FlatsomeNavDropdown` Walker) yakalayarak kendi oluşturduğu `Flatsome_Dropdown_Walker` yapısı ile değiştirir. Flatsome'ın devasa sütun odaklı menü listesini standart bir `<ul class="sub-menu">` HTML listesine dönüştürür ve eski CSS'i ezerek yerine güzel animasyonlu klasik CSS yapısını entegre eder.

Üzerine geldiğinizde, alt menüler de otomatik olarak ana kapsayıcıların çerçeve dışına (sağa) taşacak şekilde konumlandırılır. Mobil cihazlar (max-width algılandığında) bu yapıyı göz ardı eder ve native Flatsome kurgusuna geçer.

## 🛡️ Güvenlik Kalkanı
Eklenti dışarıdan sızıntılara (XSS vs.) ve CSS manipülasyonlarına karşı defansif yazılmıştır:
- CSS oluşturucu esnasında Customizer çıktılarının tamamına yönelik `absint` veya `esc_attr` parametreleri uygulanır.
- Açık/Koyu RGBA geçişlerinin doğru sağlanabilmesi için manuel "RGB/HEX Regex String Filter" mekanizması mevcuttur.
- Oluşturulan menü metinleri ekrana basılmadan evvel, herhangi bir dış scripti engellemek üzere HTML olarak `wp_kses_post()` kontrolünden geçirilir.

## 🤝 Katkıda Bulunun

Pull request'ler her zaman açıktır. Ancak köklü değişiklikler öncesinde ne üzerine değişilik yapacağımıza yönelik lütfen bir "Issue" (Sorun/Talep) açarak konuşalım.

---
[Özlem Çimen](https://www.linkedin.com/in/ozlemcimen/) tarafından geliştirildi — 
Kurumsal WordPress danışmanlığı: [Wolinka](https://wolinka.com.tr)
