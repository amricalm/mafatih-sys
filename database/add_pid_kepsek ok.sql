ALTER TABLE ep_final_grade
  ADD curriculum INT COMMENT 'pid wakasek bid pendidikan' AFTER principal,
  ADD studentaffair INT COMMENT 'pid wakasek bid kesiswaan' AFTER curriculum,
  ADD housemaster INT COMMENT 'pid kepala musyrif sakan' AFTER studentaffair,
  ADD houseleader INT COMMENT 'pid musyrif sakan' AFTER housemaster;