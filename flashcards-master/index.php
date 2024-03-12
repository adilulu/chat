<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Flashcards</title>
	<link rel="stylesheet" href="sass/style.css" />
	<link
		href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,700;1,400&family=Roboto:wght@400;500;700&display=swap"
		rel="stylesheet" />

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
		integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />
</head>
<body>
	<div class="container">
		<div class="card__intro center">
			<h1>StudyHub QuickCards</h1>
			<p class="text">Create flashcards and use it to earn better grades! Just click "Add a New Card" and enter your lesson notes. Tap the card and the answer shall appear.</p>
			<div class="card__img">
				<img src="sass/img/flashcard.svg" alt="Flashcard stack">
			</div>
			<button id="show-btn" class="btn btn--blue btn--large">Add a new card</button>
		</div>
		<div class="card-search">
	<div class="card-search__wrap">
		<input type="text" id="search">
		<button class="btn btn--green" id="search-btn">Search card</button>
		<ul id="results">
			<div id="error-search" class="error-search">There are no similar words!</div>
		</ul>
	</div>
</div>
		<div id="card-list" class="card-list"></div>
		<div class="center card-clear">
				<button id="clear" class="btn btn--green">
      <i class="fas fa-trash icon"></i> Clear Cards
    </button>
		</div>

	</div>
	<div class="card-window" id="card-window">
		<div class="card-window__wrap">		
			<a href="#" class="card-window__close icon" id="close"><i class="fas fa-window-close card-window__close"></i></a>
			<h2 class="center">Create a flashcard</h2>
			<div class="error-message">Please, fill all the fields!</div>
			<form id="card-form" class="card-form">
				<div class="card-form__group">
					<label for="question">Card question:</label>
					<textarea name="answer" id="question" cols="30" rows="10" placeholder="Type your question..."></textarea>
				</div>
				<div class="card-form__group">
					<label for="answer">Card answer:</label>
					<textarea name="answer" id="answer" cols="30" rows="10" placeholder="Type your answer..."></textarea>
				</div>
				<button type="submit" class="btn btn--green" id="save-card">Save card</button>
			</form>
			</div>
		</div>
	<script src="scripts/data.js"></script>
	<script src="scripts/ui.js"></script>
</body>
</html>

