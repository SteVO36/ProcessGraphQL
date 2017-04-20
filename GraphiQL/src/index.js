import React from 'react';
import ReactDOM from 'react-dom';
import GraphiQL from 'graphiql';
import request from 'superagent';
import 'es6-promise/auto';
import './index.css';

/**
 * This GraphiQL example illustrates how to use some of GraphiQL's props
 * in order to enable reading and updating the URL parameters, making
 * link sharing of queries a little bit easier.
 *
 * This is only one example of this kind of feature, GraphiQL exposes
 * various React params to enable interesting integrations.
 */
// Parse the search string to get url parameters.
var search = window.location.search;
var parameters = {};
search.substr(1).split('&').forEach(function (entry) {
  var eq = entry.indexOf('=');
  if (eq >= 0) {
    parameters[decodeURIComponent(entry.slice(0, eq))] =
      decodeURIComponent(entry.slice(eq + 1));
  }
});
// if variables was provided, try to format it.
if (parameters.variables) {
  try {
    parameters.variables =
      JSON.stringify(JSON.parse(parameters.variables), null, 2);
  } catch (e) {
    // Do nothing, we want to display the invalid JSON as a string, rather
    // than present an error.
  }
}
// When the query and variables string is edited, update the URL bar so
// that it can be easily shared
function onEditQuery(newQuery) {
  parameters.query = newQuery;
  updateURL();
}
function onEditVariables(newVariables) {
  parameters.variables = newVariables;
  updateURL();
}
function onEditOperationName(newOperationName) {
  parameters.operationName = newOperationName;
  updateURL();
}
function updateURL() {
  var newSearch = '?' + Object.keys(parameters).filter(function (key) {
    return Boolean(parameters[key]);
  }).map(function (key) {
    return encodeURIComponent(key) + '=' +
      encodeURIComponent(parameters[key]);
  }).join('&');
  history.replaceState(null, null, newSearch);
}
// Defines a GraphQL fetcher using the fetch API. You're not required to
// use fetch, and could instead implement graphQLFetcher however you like,
// as long as it returns a Promise or Observable.
function graphQLFetcher(graphQLParams) {
  // This example expects a GraphQL server at the path /graphql.
  // Change this to point wherever you host your GraphQL server.
  return request.post(config.ProcessGraphQL.GraphQLServerUrl) // eslint-disable-line no-undef
    .send(JSON.stringify(graphQLParams))
    .set('Accept', 'application/json')
    .set('Content-Type', 'application/json')
    .set('X-Requested-With', 'XMLHttpRequest')
    .withCredentials()
    .then(response => JSON.parse(response.text))
}
// Render <GraphiQL /> into the body.
// See the README in the top level of this module to learn more about
// how you can customize GraphiQL by providing different values or
// additional child elements.
window.onload = () => {
  ReactDOM.render(
    <GraphiQL
      fetcher={graphQLFetcher}
      query={parameters.query}
      variables={parameters.variables}
      operationName={parameters.operationName}
      onEditQuery={onEditQuery}
      onEditVariables={onEditVariables}
      onEditOperationName={onEditOperationName}
    />,
    document.getElementById('graphiql')
  );
};