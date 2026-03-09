<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AlunniController
{
  public function index(Request $request, Response $response, $args) {
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result = $mysqli_connection->query("SELECT * FROM alunni");
    $results = $result->fetch_all(MYSQLI_ASSOC);

    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function show(Request $request, Response $response, $args) {
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');

    if (!isset($args['id'])) {
      return $response->withStatus(401);
    }
    $id = $args['id'];

    $stmt = $mysqli_connection->prepare('SELECT * FROM alunni WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $response->getBody()->write(json_encode($result->fetch_all(MYSQLI_ASSOC)));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function create(Request $request, Response $response, $args) {
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');

    $data = json_decode($request->getBody(), true);

    if (!isset($data['nome'])) {
      return $response->withStatus(401);
    }
    $nome = $data['nome'];

    if (!isset($data['cognome'])) {
      return $response->withStatus(401);
    }
    $cognome = $data['cognome'];

    $stmt = $mysqli_connection->prepare('INSERT INTO alunni(nome, cognome) VALUES (?, ?)');
    $stmt->bind_param('ss', $nome, $cognome);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
      return $response->withStatus(500);
    }

    return $response->withStatus(200);
  }

  public function update(Request $request, Response $response, $args) {
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');

    if (!isset($args['id'])) {
      return $response->withStatus(401);
    }
    $id = $args['id'];

    $data = json_decode($request->getBody(), true);

    if (!isset($data['nome'])) {
      return $response->withStatus(401);
    }
    $nome = $data['nome'];

    if (!isset($data['cognome'])) {
      return $response->withStatus(401);
    }
    $cognome = $data['cognome'];

    $stmt = $mysqli_connection->prepare('UPDATE alunni SET nome = ?, cognome = ? WHERE id = ?');
    $stmt->bind_param('ssi', $nome, $cognome, $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
      return $response->withStatus(500);
    }

    return $response->withStatus(200);
  }

  public function destroy(Request $request, Response $response, $args) {
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');

    if (!isset($args['id'])) {
      return $response->withStatus(401);
    }
    $id = $args['id'];

    $stmt = $mysqli_connection->prepare('DELETE FROM alunni WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
      return $response->withStatus(500);
    }

    return $response->withStatus(200);
  }
}
