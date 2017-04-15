<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>CONCEPTUAL MODEL</title>
	</head>
	<body>
		<header>
			<h1>CONCEPTUAL MODEL</h1>
		</header>

		<main>
			<h2>Entities and Attributes</h2>
			<h3>Entities</h3>
			<ul>
				<li>Profile</li>
				<li>Product</li>
				<li>Order</li>
			</ul>
			<p>Subject: Profile</p>
			<p>Verb: Favorites</p>
			<p>Object: Furniture Items</p>
			<h3>Profile</h3>
			<ul>
				<li>profileId</li>
				<li>profileHash</li>
				<li>profileSalt</li>
				<li>profileActivationToken</li>
				<li>profileEmail</li>
				<li>profileUsername</li>
				<li>profileLocation</li>
			</ul>
			<h3>Item</h3>
			<ul>
				<li>itemId</li>
				<li>itemType</li>
				<li>itemDescription</li>
				<li>itemName</li>
				<li>itemCost</li>
			</ul>
			<h3>Favorite</h3>
			<ul>
				<li>favoriteProfileId</li>
				<li>favoriteDate</li>
				<li>favoriteItemID</li>
			</ul>


			<h2>Relationships</h2>
			<ul>
				<li>One user can favorite once for any single furniture product</li>
				<li>Many users can favorite any furniture products</li>
				<li>Many furniture products can be favorited many times</li>
			</ul>

		</main>
	</body>
</html>