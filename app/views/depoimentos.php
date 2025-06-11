 <!DOCTYPE html>
 <html lang="pt-br">
 <?php
    require_once('template/head.php');
    ?>

 <body class="page-depoimento">
     <div id="depoimento">

         <div class="container">
             <h2>Deixe seu depoimento</h2>
             <form method="POST" action="<?= BASE_URL ?>index.php?url=depoimento/enviarDepoimento">
                 <label for="descricao">Seu Depoimento:</label>
                 <textarea name="descricao" id="descricao" rows="4" required></textarea>

                 <label>Nota:</label>
                 <div class="stars">
                     <input type="radio" name="nota" id="star5" value="5">
                     <label for="star5">★</label>
                     <input type="radio" name="nota" id="star4" value="4">
                     <label for="star4">★</label>
                     <input type="radio" name="nota" id="star3" value="3">
                     <label for="star3">★</label>
                     <input type="radio" name="nota" id="star2" value="2">
                     <label for="star2">★</label>
                     <input type="radio" name="nota" id="star1" value="1" required>
                     <label for="star1">★</label>
                 </div>

                 <button type="submit">Enviar Depoimento</button>
             </form>

             <a href="<?= BASE_URL; ?>index.php?url=menu" class="btn">Voltar</a>
         </div>
     </div>


     <script>
         // Opcional: destaca estrelas selecionadas visualmente
         const stars = document.querySelectorAll('.stars input');
         stars.forEach(star => {
             star.addEventListener('change', () => {
                 const val = parseInt(star.value);
                 document.querySelectorAll('.stars label').forEach((label, index) => {
                     if (index < val) {
                         label.classList.add('selected');
                     } else {
                         label.classList.remove('selected');
                     }
                 });
             });
         });
     </script>
 </body>