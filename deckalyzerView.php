<?php


		class deckalyzerView{
			private $stylesheet = 'deckalyzer.css';
			private $pageTitle = 'Cards';

			public function __construct()
			{

			}

			public function __destruct()
			{

			}

			public function cardListView($cards, $decks, $orderBy = 'cardName', $orderDirection = 'asc', $message = '')
			{
				$body = "<h1>Cards and Decks</h1>\n";

				if ($message)
				{
					$body .= "<p class ='message'>$message</p>\n";
				}

				$body .= "<p><a class='taskButton' href='index.php?view=cardform'>+ Add Card</a>";
				$body .= "<p><a class='taskButton' href='index.php?view=deckform'>+ Add Deck</a></p>\n";

				if (count($cards) < 1 && count($decks) <1)
				{
					$body .= "<p>You don't have cards! You can fix that by clicking Add Card. Or don't.</p>\n";
					return $body;
				}

				$body .= "<span><table>\n";
				$body .= "<tr><th>Delete</th><th>Edit</th>";

				$columns = array(array('name' => 'cardName', 'label' => 'Card Name'),
								array('name' => 'numOwned', 'label' => 'Quantity'),
								array('name' => 'forTrade', 'label' => 'For Trade?'));

				foreach ($columns as $column)
				{
					$name = $column['name'];
					$label = $column['label'];
					if ($name == $orderBy)
					{
						if ($orderDirection == 'asc')
						{
							$label .= " &#x25BC;";
						}
						else
						{
							$label .= " &#x25B2;";
						}
					}
					$body .= "<th><a class='order' href='index.php?orderby=$name'>$label</a></th>";
				}

				foreach($cards as $card)
				{
					$id = $card['id'];
					$cardName = $card['name'];
					$forTrade = $card['forTrade'];
					$numOwned = $card['numOwned'];

					$body .= "<tr>";
					$body .= "<td><form action='index.php' method='post'><input type='hidden' name='action' value='delete' /><input type='hidden' name='id' value='$id' /><input type='submit' value='Delete'></form></td>";
					$body .= "<td><form action='index.php' method='post'><input type='hidden' name='action' value='edit' /><input type='hidden' name='id' value='$id' /><input type='submit' value='Edit'></form></td>";
					$body .= "<td>$cardName</td>";
					$body .= "<td>$numOwned</td>";
					$body .= "<td>$forTrade</td>";
					$body .= "</tr>\n";
                }
			$body .= "</table></span>\n";

			$body .= "<span><table>\n";
			$body .= "<tr><th>Delete</th><th>Edit</th>";

			$columns = array(array('name' => 'deckName', 'label' => 'Deck Name'),
							 array('name' => 'format', 'label' => 'Format'),
							 array('name' => 'numWins', 'label' => 'Victories'));

			foreach ($columns as $column)
				{
					$name = $column['name'];
					$label = $column['label'];
					if ($name == $orderBy)
					{
						if ($orderDirection == 'asc')
						{
							$label .= " &#x25BC;";
						}
						else
						{
							$label .= " &#x25B2;";
						}
					}
					$body .= "<th><a class='order' href='index.php?orderby=$name'>$label</a></th>";
				}

			foreach($decks as $deck)
				{
					$id = $deck['id'];
					$deckName = $deck['name'];
					$format = $deck['format'];
					$numWins = $deck['numWins'];

					$body .= "<tr>";
					$body .= "<td><form action='index.php' method='post'><input type='hidden' name='action' value='deleteD' /><input type='hidden' name='id' value='$id' /><input type='submit' value='Delete'></form></td>";
					$body .= "<td><form action='index.php' method='post'><input type='hidden' name='action' value='editD' /><input type='hidden' name='id' value='$id' /><input type='submit' value='Edit'></form></td>";
					$body .= "<td>$deckName</td>";
					$body .= "<td>$format</td>";
					$body .= "<td>$numWins</td>";
					$body .= "</tr>\n";
                }



			$body .= "</table></span>\n";

			return $this->page($body);
		}

		public function cardFormView($data = null, $message = '')
		{
			$cardName = '';
			$forTrade;
			$numOwned;

			if($data)
			{
				$cardName = $data['cardName'];
				$forTrade = $data['forTrade'];
				$numOwned = $data['numOwned'];
			}

			$html = <<<EOT1
<!DOCTYPE html>
<html>
<head>
<title>Card Manager</title>
<link rel="stylesheet" type="text/css" href="deckalyzer.css">
</head>
<body>
<h1>Cards</h1>
EOT1;


			if($message)
			{
				$html .= "<p class='message'>$message</p>\n";
			}

			$html .= "<form action='index.php' method='post'>";

			if($data['id'])
			{
				$html .="<input type='hidden' name='action' value='update' />";
				$html .= "<input type='hidden' name='id' value='{$data['id']}' />";
			}
			else
			{
				$html .= "<input type='hidden' name='action' value='add' />";
			}

			$html .= <<<EOT2
	<p>Card Name<br />
	<input type="text" name="name" value="$cardName" placeholder="Card Name" maxlength="255" size="80"></p>
	<input type="checkbox" name="forTrade" value="$forTrade">Is this card for trade?</p>
	<input type="text" name="numOwned" value="$numOwned" maxlength="4" size="8">How many of these cards do you own?</p>
	<input type="submit" name='submit' value="Submit">
</form>
</body>
</html>
EOT2;
			print $html;
		}


		public function deckFormView($data = null, $message = '')
		{
			$deckName = '';
			$format = '';
			$numWins;

			if($data)
			{
				$deckName = $data['deckName'];
				$format = $data['format'];
				$numWins = ['numWins'];
			}

			$html = <<<EOT1
<!DOCTYPE html>
<html>
<head>
<title>Cards and Deck Manager</title>
<link rel="stylesheet" type="text/css" href="deckalyzer.css">
</head>
<body>
<h1>Cards and Decks</h1>
EOT1;


			if($message)
			{
				$html .= "<p class='message'>$message</p>\n";
			}

			$html .= "<form action='index.php' method='post'>";

			if($data['id'])
			{
				$html .="<input type='hidden' name='action' value='updateD' />";
				$html .= "<input type='hidden' name='id' value='{$data['id']}' />";
			}
			else
			{
				$html .= "<input type='hidden' name='action' value='addD' />";
			}

			$html .= <<<EOT2
	<p>Deck Name<br />
	<input type="text" name="name" value="$deckName" placeholder="Deck Name" maxlength="255" size="80"></p>
	<input type="text" name="format" value="$format" placeholder="Format" maxlength="255" size="80"></p>
	<input type ="text" name="numWins" value="$numWins" maxlength="4" size="8">How many victories have you claimed with this deck?</p>
	<input type="submit" name='submit' value="Submit">
</form>
</body>
</html>
EOT2;
			print $html;
		}

		private function page($body) {
			$html = <<<EOT
<!DOCTYPE html>
<html>
<head>
<title>{$this->pageTitle}</title>
<link rel="stylesheet" type="text/css" href="{$this->stylesheet}">
</head>
<body>
$body
<p>&copy; 2018 Warren Allen, Emily Eden, and Luke Fisher. All rights reserved. Yeet.</p>
</body>
</html>
EOT;
			return $html;
		}



        }
