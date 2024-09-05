# Bestseller Book Block Plugin

## Description
The **Bestseller Book Block** is a custom WordPress block that allows editors to display the current best-selling book in a selected genre. 
The block pulls data from the Biblio API and displays the book's title, cover image, and author(s). A "Buy Now" button links to Amazon, and the book cover links to Penguin UK.

## Features
- **Genre Selection**: Users can select a genre from a dropdown list that is prepopulated with data from the Biblio API.
- **Dynamic Book Display**: The best-selling book in the selected genre is displayed with its title, cover image, authors (up to 2), and relevant links.
- 
## Requirements
- WordPress 5.8+

## Installation

1. **Upload the Plugin**:
   - Download the plugin as a zipped file.
   - Go to the WordPress Admin Dashboard.
   - Navigate to **Plugins > Add New**.
   - Click on **Upload Plugin** and select the plugin's `.zip` file.
   - Install and activate the plugin.

2. **Activate the Plugin**:
   - Once installed, navigate to the **Plugins** page.
   - Find the **Bestselling Books Block Plugin** in the list and click **Activate**.

## Usage

1. **Add the Page**:
   - In the WordPress editor (Gutenberg), insert a new block.
   - Use ['biblio_bestsellers'] shortcode.

2. **Publish the Page**:
   - Once you are satisfied with the display, publish or update your post or page.
