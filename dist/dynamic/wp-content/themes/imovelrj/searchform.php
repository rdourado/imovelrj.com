<form action="<?php echo home_url( '/' ); ?>" class="head-search" method="get">
	<fieldset>
		<legend>O melhor atendimento por m²</legend>
		<label for="s">Busque o imóvel dos seus sonhos</label>
		<p class="head-field">
			<input class="head-input" id="s" name="s" placeholder="Busque o imóvel dos seus sonhos" required type="text">
			<button class="head-submit" type="submit">Ok</button>
		</p>
		<a class="head-advanced" href="<?php echo get_permalink(get_page_by_path('busca-avancada')); ?>">Faça uma busca avançada aqui</a>
	</fieldset>
</form>
