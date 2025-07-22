export const sanitizeIconHTML_2_15_0 = ( html ) => {
	// Remove all tags except <i> and </i>
	return html.replace( /<(?!\/?i\b)[^>]+>/g, '' );
};
