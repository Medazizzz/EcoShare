<?php
include __DIR__.'/base.html.twig.php';
$title = 'EcoShare — Dashboard';
ob_start(); ?>
<div class="layout">
  <aside class="sidebar">
    <h3>EcoShare</h3>
    <ul style="list-style:none;padding:0;margin-top:1rem">
      <li><a href="/dashboard" style="color:white;text-decoration:none">Vue d'ensemble</a></li>
      <li style="margin-top:.5rem"><a href="#" style="color:white;text-decoration:none">Événements</a></li>
      <li style="margin-top:.5rem"><a href="#" style="color:white;text-decoration:none">Outils partagés</a></li>
    </ul>
  </aside>

  <section class="main">
    <h2>Tableau de bord</h2>
    <p style="color:var(--muted)">Aperçu rapide des activités récentes</p>

    <div class="grid" style="margin-top:1rem">
      <div class="kpi">
        <h4>Événements ce mois</h4>
        <p style="font-size:1.5rem;margin:0">12</p>
      </div>
      <div class="kpi">
        <h4>Membres actifs</h4>
        <p style="font-size:1.5rem;margin:0">289</p>
      </div>
      <div class="kpi">
        <h4>Objets partagés</h4>
        <p style="font-size:1.5rem;margin:0">76</p>
      </div>
    </div>

    <div style="margin-top:1.5rem">
      <div class="card">
        <h3>Dernières actions</h3>
        <ul>
          <li>Nettoyage de plage — 28 Septembre</li>
          <li>Atelier compost — 03 Octobre</li>
          <li>Collecte de plantes — 10 Octobre</li>
        </ul>
      </div>
    </div>

  </section>
</div>
<?php $content = ob_get_clean(); include __DIR__.'/base.html.twig.php';
?>
