// Detect the base URL dynamically
var baseURL = window.location.origin;

// Get the first directory after the domain (if exists)
var pathSegments = window.location.pathname
  .split("/")
  .filter((segment) => segment !== "");
if (pathSegments.length > 0) {
  baseURL += "/" + pathSegments[0]; // Append first directory if exists
}
