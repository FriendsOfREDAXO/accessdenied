# Access Denied Addon for REDAXO

![Screenshot](https://raw.githubusercontent.com/FriendsOfREDAXO/accessdenied/assets/screenshot.png)

Access Denied is an addon for the REDAXO CMS that provides additional control over article and category accessibility in the frontend. It introduces a "restricted" status, allowing administrators to block access to certain content.

## Features

- **Restrict Articles and Categories**: Adds a "restricted" status to articles and categories, making them unavailable in the frontend.
- **Preview Links**: Generates shareable preview links for restricted content.
- **Inheritance**: Restricting a category can optionally restrict all its subcategories and articles.
- **Automatic Redirection**: Restricted pages redirect to the "not found" article unless accessed with a preview parameter or from the backend.

## Settings

Access Denied settings can be found under System settings:

- **Default Status**: Choose whether new articles and categories are created as online, offline, or restricted.
- **Inheritance Control**: Enable or disable the inheritance of the restricted status to subcategories and articles.

## Usage Instructions

- **Search Indexing**: If using search_it, regenerate the search index after restricting an article or category.
- **Multi-Domain Environments**: Ensure REDAXO users are logged in under the appropriate domain to view restricted content in the frontend. See [issue #22](https://github.com/FriendsOfREDAXO/accessdenied/issues/22) for more details.

## Uninstallation

Upon uninstallation, all restricted articles are set to offline.

## License

This project is licensed under the [MIT License](LICENSE.md).

## Author

**Friends Of REDAXO**

- Website: [REDAXO](http://www.redaxo.org)
- GitHub: [FriendsOfREDAXO](https://github.com/FriendsOfREDAXO)

## Leads

- [Thomas Skerbis](https://github.com/skerbis)
- Alexander Walther (@alxndr-w)

## Credits

- **Initial REDAXO 4 Version**: Koala (Sven Eichler)
- **REDAXO 5 Port**: @Hirbod
- **Default Status Implementation**: Alexander Walther (@alxndr-w)
- **Inheritance and Sharing Features**: @skerbis
